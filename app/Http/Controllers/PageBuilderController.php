<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlocksRequest;
use App\Models\Author;
use App\Models\Category;
use App\Models\Pattern;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PageBuilderController extends Controller
{
    /**
     * Discover and load blocks from resources/js/blocks.
     *
     * @return Collection
     */
    public static function registeredBlocks(): Collection
    {
        $blocks = collect();
        $path = resource_path('js/blocks');

        if (!is_dir($path)) {
            return $blocks;
        }

        $directories = File::directories($path);

        foreach ($directories as $dir) {
            $jsonPath = $dir . DIRECTORY_SEPARATOR . 'block.json';
            if (!File::exists($jsonPath)) {
                continue;
            }

            $raw = File::get($jsonPath);
            $data = json_decode($raw, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
                continue;
            }

            if (isset($data['label'])) {
                $data['label'] = __($data['label']);
            }

            if (!isset($data['children'])) {
                $data['children'] = [];
            }

            $data['attributes'] = self::resolveBlockAttributes($data);

            $blocks->push($data);
        }

        return $blocks->values();
    }
    /**
     * Get the flattened feature attribute keys enabled for a given block type.
     *
     * @param string $type
     * @return Collection
     */
    public static function blockFeatures($type): Collection
    {
        $features = collect();
        $block = registered_block($type);
        if ($block) {
            $blockFeatures = data_get($block, 'features', []);
            foreach ($blockFeatures as $group) {
                $features->push(array_keys(self::featureAtts($group)));
            }
        }
        return $features->flatten();
    }
    /**
     * Collect all feature attribute keys across all registered blocks.
     *
     * @return Collection
     */
    public static function registeredFeatures(): Collection
    {
        $blocks = self::registeredBlocks();
        $features = collect();
        $blocks->each(function ($block) use (&$features) {
            $blockFeatures = data_get($block, 'features', []);
            foreach ($blockFeatures as $feature) {
                $featureAtts = self::featureAtts($feature);
                foreach (array_keys($featureAtts) as $f) {
                    if (!$features->contains($f)) {
                        $features->push($f);
                    }
                }
            }
        });
        return $features;
    }

    public static function features(): Collection
    {
        $features = [];
        $path = resource_path('js/blocks/features.json');
        if (File::exists($path)) {
            $raw = File::get($path);
            $data = json_decode($raw, true);

            if (json_last_error() == JSON_ERROR_NONE || is_array($data)) {
                $features = $data;
            }
        }
        return collect($features);
    }
    /**
     * Map a feature group to its attribute schema definition.
     *
     * Accepts:
     *  - string feature name (e.g. "typography")
     *  - array of feature names (e.g. ["typography", "bgColor"])
     *  - associative array to override defaults (e.g. ["typography" => ["fontSize" => "16px"]])
     *
     * @param string|array $feature
     * @return array|null
     */
    public static function featureAttributes($feature)
    {
        $all = self::features()->toArray();

        // string key
        if (is_string($feature)) {
            return $all[$feature] ?? [];
        }

        // array (list or associative)
        if (is_array($feature)) {
            $result = [];

            // numeric-indexed list: ["typography", "bgColor"]
            // associative: ["typography" => ["fontSize" => "16px"], "bgImage" => true]
            foreach ($feature as $key => $value) {
                if (is_int($key)) {
                    // value may be string or nested array
                    if (is_string($value)) {
                        $result = array_merge($result, self::featureAttributes($value));
                    } elseif (is_array($value)) {
                        // nested array: treat like associative map
                        $result = array_merge($result, self::featureAttributes($value));
                    }
                    continue;
                }

                // $key is feature name, $value can be:
                //  - false => skip
                //  - true  => include whole feature
                //  - array  => override defaults for attributes in that feature
                if ($value === false) {
                    continue;
                }

                $base = $all[$key] ?? [];
                if (empty($base)) {
                    continue;
                }

                if ($value === true || $value === null) {
                    // include base as-is
                    $result = array_merge($result, $base);
                    continue;
                }

                if (is_array($value)) {
                    // apply overrides to defaults
                    foreach ($base as $attKey => $attDef) {
                        if (array_key_exists($attKey, $value)) {
                            // replace default only (keep rules/type)
                            $attDef['default'] = $value[$attKey];
                        }
                        $result[$attKey] = $attDef;
                    }
                } else {
                    // unexpected scalar — include base
                    $result = array_merge($result, $base);
                }
            }

            return $result;
        }

        return [];
    }

    /**
     * Backwards-compatible alias used across this controller.
     *
     * @param mixed $feature
     * @return array
     */
    public static function featureAtts($feature)
    {
        return self::featureAttributes($feature);
    }

    /**
     * Merge feature-driven attributes into a block's base attributes.
     *
     * @param array $block
     * @return array
     */
    public static function resolveBlockAttributes($block)
    {
        $features = data_get($block, 'features', []);
        $atts = data_get($block, 'attributes', []);
        foreach ($features as $feature) {
            $featureAtts = self::featureAtts($feature);
            foreach ($featureAtts as $k => $v) {
                $atts[$k] = $v;
            }
        }
        return $atts;
    }
    /**
     * Default spacing attribute structure for responsive breakpoints.
     *
     * @return array
     */
    public static function spacingAttributes()
    {
        $atts = [];
        foreach (['sm', 'md', 'lg', 'xl'] as $breakpoint) {
            $atts[$breakpoint] = [
                'top' => '',
                'start' => '',
                'end' => '',
                'bottom' => '',
            ];
        }
        return $atts;
    }
    /**
     * Normalize a tree of registered blocks (add ids, resolve attributes, recurse children).
     *
     * @param array $blocks
     * @return array
     */
    public static function resolveRegisteredBlocks(array $blocks)
    {
        return arr_map($blocks, function ($block) {
            $block = array_merge($block, [
                'id' => uniqid('block-'),
            ]);
            $block['attributes'] = self::resolveBlockAttributes($block);
            $children = data_get($block, 'children');
            if ($children && is_array($children) && !empty($children)) {
                $block['children'] = static::resolveRegisteredBlocks($children);
            }
            return $block;
        });
    }
    /**
     * Find a registered block by type.
     *
     * @param string $type
     * @return array|null
     */
    public static function registeredBlock($type): array | null
    {
        return self::registeredBlocks()->firstWhere('type', $type);
    }
    /**
     * Get array of all registered block types.
     *
     * @return array
     */
    public static function blockTypes()
    {
        return self::registeredBlocks()->map(fn($block) => data_get($block, 'type'))->toArray();
    }
    /**
     * Back-compat: return rules array for a block type (if any).
     *
     * @param string $type
     * @return array
     */
    public static function blockRuless($type)
    {
        $blocks = self::registeredBlocks();
        $block = collect($blocks)->firstWhere('type', $type);
        return $block ? ($block['rules'] ?? []) : [];
    }
    /**
     * Build validation rules array from a block's attribute schema.
     *
     * @param string $type
     * @return array
     */
    public static function blockRules($type): array
    {
        $block = self::registeredBlock($type);
        if ($block) {
            $rules = [];
            $attributes = data_get($block, 'attributes', []);
            foreach ($attributes as $k => $v) {
                $rules[$k] = data_get($v, 'rules', []);
            }
            return $rules;
        } else {
            return [];
        }
    }

    /**
     * Extract default values for all attributes of a block type.
     *
     * @param string $type
     * @return array
     */
    public static function blockDefaults($type): array
    {
        $block = self::registeredBlock($type);
        $defaults = [];
        if ($block) {
            $attributes = data_get($block, 'attributes', []);
            foreach ($attributes as $k => $v) {
                $defaults[$k] = data_get($v, 'default');
            }
        }
        return $defaults;
    }

    /**
     * Render the page builder UI with necessary datasets.
     *
     * @param Request $request
     * @param Post $page
     * @return Response
     */
    public function index(Request $request, Post $page): Response
    {
        $page->updateMeta('builder_enabled', true);
        return Inertia::render('builder/Index', [
            'page' => $page->toArray(),
            'pages' => Post::type('page')->publish()->get()->toArray(),
            'categories' => fn() => Category::type('category')->with('children')->get()->toArray(),
            'tags' => fn() => Category::type('tag')->get()->toArray(),
            'authors' => fn() => Author::publish()->get()->toArray(),
            'users' => fn() => User::all()->toArray(),
            'sortOptions' => fn() => sort_options(),
            'registeredBlocks' => fn() => self::registeredBlocks()->toArray(),
            'patterns' => fn() => Pattern::all()->toArray(),
        ])
            ->rootView('layouts.inertia')
            ->withViewData([
                'title' => __('Edit page ":name"', ['name' => $page->name]),
                'containerClass' => 'page-builder-container',
                'showTitle' => false,
            ]);
    }

    /**
     * Persist builder blocks for a page.
     *
     * @param StoreBlocksRequest $request
     * @param Post $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBlocksRequest $request, Post $page)
    {
        $blocks = data_get($request->validated(), 'blocks', []);
        // dd($blocks);
        $save = $page->saveBlocks($blocks);
        if ($save) {
            return back()->with('save', __('Saved successfully.'));
        } else {
            return back()->withErrors(['save', __('Save failed!')]);
        }
    }

    /**
     * Render a single block payload server-side and return its HTML.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable|string
     */
    public function renderBlock(Request $request)
    {
        return block($request->all())->render();
    }
    /**
     * Return the block preview view for a given block payload.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function blockPreview(Request $request)
    {
        return view('components.block-preview', [
            'block' => $request->all(),
        ]);
    }
    /**
     * Resolve media conversions (original + generated conversions) to URLs map.
     *
     * @param Media $media
     * @return array
     */
    public function resolveConversions(Media $media)
    {
        $conversions = [
            'full' => $media->getUrl(),
        ];
        $generated = $media->generated_conversions ?? [];

        if (is_iterable($generated)) {
            foreach ($generated as $name => $available) {
                if ($available) {
                    // getUrl(name) -> conversion url, getUrl() -> original
                    $conversions[$name] = $media->getUrl($name);
                }
            }
        }
        return $conversions;
    }

    /**
     * Transform a Media model to array with conversions map.
     *
     * @param Media $media
     * @return array
     */
    public function resolveImage(Media $media): array
    {
        return array_merge($media->toArray(), [
            'conversions' => $this->resolveConversions($media),
        ]);
    }
    /**
     * List images attached to a page for the builder image picker.
     *
     * @param Post $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function pageImages(Post $page)
    {
        return response()->json(
            $page->getMedia('images')->map(fn(Media $media) => $this->resolveImage($media))->toArray()
        );
    }
    /**
     * Upload an image and attach it to the page's images collection.
     *
     * @param Request $request
     * @param Post $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request, Post $page)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,webp,gif,svg|max:5120',
        ]);

        $image = $request->file('image');

        // Add image to the "images" media collection
        $media = $page->addMedia($image)
            ->toMediaCollection('images');

        return response()->json($this->resolveImage($media));
    }

    /**
     * Switch the editor mode back to the classic editor.
     *
     * @param Post $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function classic(Post $page)
    {
        $page->updateMeta('builder_enabled', false);
        return redirect($page->edit_url);
    }
}
