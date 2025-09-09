<?php
if (!function_exists('og_data')) {
    function og_data($data = [])
    {
        $og = [
            ...[
                'site_name' => site_name(),
                'type' => 'artical',
            ],
            ...$data,
        ];
        $image = null;
        $route = request()->route();
        if ($route) {
            $name = $route->getName();
            $params = $route->parameters();
            if (is_author() || is_book() || is_post() || is_user()) {
                $model = data_get($params, $name);
                if ($model && method_exists($model, 'getThumbnailUrl')) {
                    $image = $model->getThumbnailUrl('md');
                    if ($image) {
                        $og['image'] = $image;
                        $og['image:type'] = 'image/webp';
                        $og['image:width'] = 600;
                        $og['image:height'] = 337.5;
                    }
                }
            } elseif (is_quote()) {
                $quote = data_get($params, 'quote');
                if ($quote && method_exists($quote, 'getThumbnailUrl')) {
                    $image = $quote->getThumbnailUrl('md');
                    if ($image) {
                        $og['image'] = $image;
                        $og['image:type'] = 'image/webp';
                        $og['image:width'] = 600;
                        $og['image:height'] = 337.5;
                    }
                }
            }
        }
        return $og;
    }
}
