<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public static function defaultSettings(): array
    {
        return [
            [
                'type' => 'string',
                'key' => 'name',
                'value' => 'FadGram starter',
            ],
            [
                'type' => 'string',
                'key' => 'description',
                'value' => 'FadGram starter kit project',
            ],
            [
                'type' => 'string',
                'key' => 'url',
                'value' => 'http://localhost:8000',
            ],
            [
                'type' => 'file',
                'key' => 'logo',
                'value' => public_path('assets/images/logo.png'),
            ],
            [
                'type' => 'file',
                'key' => 'logo_light',
                'value' => public_path('assets/images/logo-light.png'),
            ],
            [
                'type' => 'string',
                'key' => 'logo_width',
                'value' => null,
            ],
            [
                'type' => 'string',
                'key' => 'logo_height',
                'value' => 35,
            ],
            [
                'type' => 'file',
                'key' => 'favicon',
                'value' => public_path('assets/images/favicon.ico'),
            ],
            [
                'type' => 'boolean',
                'key' => 'logo_label_enabled',
                'value' => false,
            ],
            [
                'type' => 'string',
                'key' => 'locale',
                'value' => 'en',
            ],
            [
                'type' => 'string',
                'key' => 'timezone',
                'value' => 'UTC',
            ],
            [
                'type' => 'string',
                'key' => 'date_format',
                'value' => 'j F، Y',
            ],
            [
                'type' => 'boolean',
                'key' => 'maintenance',
                'value' => false,
            ],
            [
                'type' => 'boolean',
                'key' => 'closed',
                'value' => false,
            ],
            [
                'type' => 'boolean',
                'key' => 'users_can_register',
                'value' => true,
            ],
            [
                'type' => 'array',
                'key' => 'default_roles',
                'value' => [
                    'member',
                ],
            ],
            [
                'type' => 'boolean',
                'key' => 'email_verification_required',
                'value' => false,
            ],
            [
                'type' => 'boolean',
                'key' => 'ads_auto_enabled',
                'value' => false,
            ],
            [
                'type' => 'string',
                'key' => 'ads_auto_code',
                'value' => null,
            ],
            [
                'type' => 'boolean',
                'key' => 'ads_above_content_enabled',
                'value' => false,
            ],
            [
                'type' => 'string',
                'key' => 'ads_above_content_code',
                'value' => null,
            ],
            [
                'type' => 'boolean',
                'key' => 'ads_below_content_enabled',
                'value' => false,
            ],
            [
                'type' => 'string',
                'key' => 'ads_below_content_code',
                'value' => null,
            ],
            [
                'type' => 'boolean',
                'key' => 'header_code_enabled',
                'value' => false,
            ],
            [
                'type' => 'string',
                'key' => 'header_code',
                'value' => null,
            ],
            [
                'type' => 'boolean',
                'key' => 'backtop_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'footer_copyrights',
                'value' => 'Copyrights reserved @ :link | :year',
            ],
            [
                'type' => 'boolean',
                'key' => 'footer_code_enabled',
                'value' => false,
            ],
            [
                'type' => 'string',
                'key' => 'footer_code',
                'value' => null,
            ],
            [
                'type' => 'boolean',
                'key' => 'custom_css_enabled',
                'value' => false,
            ],
            [
                'type' => 'string',
                'key' => 'custom_css',
                'value' => null,
            ],
            [
                'type' => 'boolean',
                'key' => 'custom_js_enabled',
                'value' => false,
            ],
            [
                'type' => 'string',
                'key' => 'custom_js',
                'value' => null,
            ],
            [
                'type' => 'boolean',
                'key' => 'eruda_enabled',
                'value' => false,
            ],
            [
                'type' => 'string',
                'key' => 'font_family',
                'value' => 'sans',
            ],
            [
                'type' => 'string',
                'key' => 'font_smoothing',
                'value' => 'antialiased',
            ],
            [
                'type' => 'string',
                'key' => 'font_size',
                'value' => null,
            ],
            [
                'type' => 'string',
                'key' => 'front_type',
                'value' => 'posts',
            ],
            [
                'type' => 'string',
                'key' => 'front_page',
                'value' => null,
            ],
            [
                'type' => 'string',
                'key' => 'posts_page',
                'value' => null,
            ],
            [
                'type' => 'number',
                'key' => 'posts_per_page',
                'value' => 10,
            ],
            [
                'type' => 'boolean',
                'key' => 'disable_search_engines',
                'value' => false,
            ],
            [
                'type' => 'boolean',
                'key' => 'excerpt_enabled',
                'value' => true,
            ],
            [
                'type' => 'number',
                'key' => 'excerpt_length',
                'value' => 139,
            ],
            [
                'type' => 'string',
                'key' => 'excerpt_more',
                'value' => '...',
            ],
            [
                'type' => 'boolean',
                'key' => 'excerpt_preverse_words',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'share_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'share_label',
                'value' => __('Share:'),
            ],
            [
                'type' => 'array',
                'key' => 'share_buttons',
                'value' => [
                    [
                        'enabled' => true,
                        'name' => 'instagram',
                        'icon' => 'bi-instagram',
                        'url' => 'https://instagram.com/share/url={permalink}',
                    ],
                    [
                        'enabled' => true,
                        'name' => 'snapchat',
                        'icon' => 'bi-snapchat',
                        'url' => 'https://snapchat.com/share/url={permalink}',
                    ],
                    [
                        'enabled' => true,
                        'name' => 'telegram',
                        'icon' => 'bi-telegram',
                        'url' => 'https://t.me/share/url?url={permalink}',
                    ],
                    [
                        'enabled' => true,
                        'name' => 'pinterest',
                        'icon' => 'bi-pinterest',
                        'url' => 'https://pinterest.com/share/url?url={permalink}',
                    ],
                    [
                        'enabled' => true,
                        'name' => 'linkedin',
                        'icon' => 'bi-linkedin',
                        'url' => 'https://www.linkedin.com/shareArticle?url={permalink}',
                    ],
                    [
                        'enabled' => true,
                        'name' => 'whatsapp',
                        'icon' => 'bi-whatsapp',
                        'url' => 'https://wa.me/?text={name}\n{permalink}',
                    ],
                    [
                        'enabled' => true,
                        'name' => 'twitter',
                        'icon' => 'bi-twitter',
                        'url' => 'https://twitter.com/intent/tweet?url={permalink}',
                    ],
                    [
                        'enabled' => true,
                        'name' => 'facebook',
                        'icon' => 'bi-facebook',
                        'url' => 'https://www.facebook.com/sharer/sharer.php?u={permalink}',
                    ],
                ],
            ],
            [
                'type' => 'boolean',
                'key' => 'post_meta_enabled',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'post_meta_author',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'post_meta_date',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'post_meta_categories',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'post_meta_views',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'post_meta_comments',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'post_tags_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'post_tags_label',
                'value' => __('Tags'),
            ],
            [
                'type' => 'boolean',
                'key' => 'post_share_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'post_share_label',
                'value' => __('Share ":name"'),
            ],
            [
                'type' => 'boolean',
                'key' => 'post_next_prev_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'post_next_label',
                'value' => __('Next'),
            ],
            [
                'type' => 'string',
                'key' => 'post_prev_label',
                'value' => __('Previous'),
            ],
            [
                'type' => 'boolean',
                'key' => 'related_posts_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'related_posts_label',
                'value' => __('Related posts'),
            ],
            [
                'type' => 'number',
                'key' => 'related_posts_count',
                'value' => 5,
            ],
            [
                'type' => 'string',
                'key' => 'related_posts_query',
                'value' => 'category',
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_books_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'quote_books_label',
                'value' => __('Books'),
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_meta_enabled',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_meta_author',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_meta_date',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_meta_categories',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_meta_views',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_meta_comments',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_tags_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'quote_tags_label',
                'value' => __('Tags'),
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_share_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'quote_share_label',
                'value' => __('Share ":name"'),
            ],
            [
                'type' => 'boolean',
                'key' => 'quote_next_prev_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'quote_next_label',
                'value' => __('Next'),
            ],
            [
                'type' => 'string',
                'key' => 'quote_prev_label',
                'value' => __('Previous'),
            ],
            [
                'type' => 'boolean',
                'key' => 'related_quotes_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'related_quotes_label',
                'value' => __('Related quotes'),
            ],
            [
                'type' => 'number',
                'key' => 'related_quotes_count',
                'value' => 5,
            ],
            [
                'type' => 'string',
                'key' => 'related_quotes_query',
                'value' => 'category',
            ],
            [
                'type' => 'boolean',
                'key' => 'book_meta_enabled',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'book_meta_author',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'book_meta_date',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'book_meta_categories',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'book_meta_views',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'book_meta_comments',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'book_tags_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'book_tags_label',
                'value' => __('Tags'),
            ],
            [
                'type' => 'boolean',
                'key' => 'book_share_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'book_share_label',
                'value' => __('Share ":name"'),
            ],
            [
                'type' => 'boolean',
                'key' => 'book_display_quotes',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'book_quotes_section_title',
                'value' => 'Quotes from book ":name"',
            ],
            [
                'type' => 'boolean',
                'key' => 'book_add_quote',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'book_quote_approve_required',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'book_quote_approve_previous',
                'value' => true,
            ],
            [
                'type' => 'number',
                'key' => 'book_quotes_per_page',
                'value' => 5,
            ],
            [
                'type' => 'string',
                'key' => 'book_quotes_sort',
                'value' => 'newest',
            ],
            [
                'type' => 'boolean',
                'key' => 'book_next_prev_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'book_next_label',
                'value' => __('Next'),
            ],
            [
                'type' => 'string',
                'key' => 'book_prev_label',
                'value' => __('Previous'),
            ],
            [
                'type' => 'boolean',
                'key' => 'related_books_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'related_books_label',
                'value' => __('Related books'),
            ],
            [
                'type' => 'number',
                'key' => 'related_books_count',
                'value' => 5,
            ],
            [
                'type' => 'string',
                'key' => 'related_books_query',
                'value' => 'category',
            ],
            [
                'type' => 'boolean',
                'key' => 'comments_enabled',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'comments_login_required',
                'value' => false,
            ],
            [
                'type' => 'boolean',
                'key' => 'comments_name_email_required',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'comments_auto_close',
                'value' => false,
            ],
            [
                'type' => 'number',
                'key' => 'comments_auto_close_days',
                'value' => 7,
            ],
            [
                'type' => 'boolean',
                'key' => 'comments_nested_enabled',
                'value' => true,
            ],
            [
                'type' => 'number',
                'key' => 'comments_nested_level',
                'value' => 5,
            ],
            [
                'type' => 'number',
                'key' => 'comments_per_page',
                'value' => 5,
            ],
            [
                'type' => 'string',
                'key' => 'comments_sort',
                'value' => 'newest',
            ],
            [
                'type' => 'boolean',
                'key' => 'comments_approve_required',
                'value' => true,
            ],
            [
                'type' => 'boolean',
                'key' => 'comments_approve_previous',
                'value' => true,
            ],
            [
                'type' => 'number',
                'key' => 'comments_hold_links',
                'value' => 2,
            ],
            [
                'type' => 'boolean',
                'key' => 'comments_avatar_enabled',
                'value' => true,
            ],
            [
                'type' => 'string',
                'key' => 'comments_hold_words',
                'value' => null,
            ],
            [
                'type' => 'string',
                'key' => 'comments_black_list',
                'value' => null,
            ],
        ];
    }
    public static function all()
    {
        return collect(self::defaultSettings());
    }
    public static function getDefaultOption(string $key, $defaultValue = null)
    {
        $setting = arr_first(self::defaultSettings(), function ($data) use ($key) {
            return data_get($data, 'key') === $key;
        });
        return $setting ? resolve_option_value(data_get($setting, 'type'), data_get($setting, 'value')) : $defaultValue;
    }
    public static function getDefaultOptionType(string $key, $default = null)
    {
        $setting = arr_first(self::defaultSettings(), function ($data) use ($key) {
            return data_get($data, 'key') === $key;
        });
        return data_get($setting, 'type', $default);
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = self::defaultSettings();
        foreach ($defaultSettings as $item) {
            $type = data_get($item, 'type');
            $key = data_get($item, 'key');
            $originalValue = data_get($item, 'value');
            $value = match ($type) {
                'array' => json_encode($originalValue),
                'file' => null,
                default => $originalValue,
            };
            $setting = Setting::create([
                'type' => $type,
                'key' => $key,
                'value' => $value,
            ]);
            if ($setting && $type === 'file') {
                if (is_array($originalValue)) {
                    foreach ($originalValue as $file) {
                        $setting->addMedia($file)->preservingOriginal()->toMediaCollection($key);
                    }
                } elseif (is_string($originalValue)) {
                    $setting->addMedia($originalValue)->preservingOriginal()->toMediaCollection($key);
                }
            }
        }
    }
}
