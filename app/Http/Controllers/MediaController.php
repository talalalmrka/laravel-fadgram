<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function resolveConversions(Media $media): array
    {
        $conversions = [
            'full' => $media->getUrl(),
        ];
        $generated = $media->generated_conversions ?? [];

        if (is_iterable($generated)) {
            foreach ($generated as $name => $available) {
                if ($available) {
                    $conversions[$name] = $media->getUrl($name);
                }
            }
        }
        return $conversions;
    }

    public function resolveMedia(Media $media): array
    {
        return array_merge($media->toArray(), [
            'ext' => $media->extension,
            'human_size' => $media->humanReadableSize,
            ...$media->generated_conversions ? [
                'conversions' => $this->resolveConversions($media),
            ] : [],
        ]);
    }
    public function resolveModelType($type)
    {
        return match ($type) {
            'post' => 'App\Models\Post',
            'book' => 'App\Models\Book',
            'quote' => 'App\Models\Quote',
            'quoteImage' => 'App\Models\QuoteImage',
            default => null,
        };
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model_type = $request->get('model_type');
        $model_id = $request->get('model_id');
        $type = $request->get('type');
        $per_page = $request->get('per_page', 10);
        $search = $request->get('search');
        $search_fields = $request->get('search_fields', [
            'name',
            'model_type',
            'mime_type',
            'collection_name',
        ]);
        $page = $request->get('page', 1);
        $query = Media::query();
        $model_class = $this->resolveModelType($model_type);
        if ($model_class) {
            $query->where('model_type', $model_class);
        }
        if ($model_id) {
            $query->where('model_id', $model_id);
        }
        if ($type) {
            $query->where('mime_type', 'like', "%{$type}%");
        }
        if ($search) {
            $query->where(function ($q) use ($search, $search_fields) {
                foreach ($search_fields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }
        $media = $query->orderBy('created_at', 'desc')
            ->paginate($per_page, ['*'], 'page', $page);
        return response()->json($media->map(fn(Media $media) => $this->resolveMedia($media))->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:10240',
        ]);

        $file = $request->file('file');
        $model_type = $request->get('model_type');
        $model_id = $request->get('model_id');
        $collection = $request->get('collection', 'default');
        $model = null;
        if ($model_type && $model_id) {
            $model = app($this->resolveModelType($model_type))->find($model_id);
        }
        if (!$model) {
            $model = current_user();
        }
        // Add image to the "images" media collection
        $media = $model->addMedia($file)
            ->toMediaCollection($collection);

        return response()->json($this->resolveMedia($media));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        $media->delete();
        return response()->json(['success' => true]);
    }
}
