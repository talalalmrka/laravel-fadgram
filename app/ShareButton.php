<?php

namespace App;

class ShareButton
{
    public bool $enabled;
    public $name;
    public $icon;
    public $url;

    /**
     * Create a new class instance.
     */
    public function __construct($enabled, $name, $icon, $url)
    {
        $this->enabled = $enabled;
        $this->name = $name;
        $this->icon = $icon;
        $this->url = $url;
    }
    public static function make($data)
    {
        return new static(
            data_get($data, 'enabled'),
            data_get($data, 'name'),
            data_get($data, 'icon'),
            data_get($data, 'url'),
        );
    }
    public static function all()
    {
        $allButtons = get_option('share_buttons', []);
        $buttons = collect([]);
        foreach ($allButtons as $buttonData) {
            $button = self::make($buttonData);
            $buttons->push($button);
        }
        return $buttons;
    }
    public static function enabled()
    {
        return self::all()->where('enabled', true);
    }

    public function shareUrl($post)
    {
        return share_url($this->url, $post);
    }
    public function buttonClass()
    {
        $classes = [
            'instagram' => 'btn-instagram',
            'snapchat' => 'btn-snapchat',
            'telegram' => 'btn-telegram',
            'pinterest' => 'btn-pinterest',
            'tiktok' => 'btn-tiktok',
            'linkedin' => 'btn-linkedin',
            'whatsapp' => 'btn-whatsapp',
            'twitter' => 'btn-twitter',
            'facebook' => 'btn-facebook',
        ];
        return data_get($classes, strtolower($this->name));
    }
    public function textClass()
    {
        $classes = [
            'instagram' => 'text-instagram',
            'snapchat' => 'text-snapchat',
            'telegram' => 'text-telegram',
            'pinterest' => 'text-pinterest',
            'tiktok' => 'text-tiktok',
            'linkedin' => 'text-linkedin',
            'whatsapp' => 'text-whatsapp',
            'twitter' => 'text-twitter',
            'facebook' => 'text-facebook',
        ];
        return data_get($classes, strtolower($this->name));
    }
    public function button($post, $data = [])
    {
        $class = data_get($data, 'class');
        return a(array_merge($data, [
            'href' => $this->shareUrl($post),
            'target' => '_blank',
            'title' => $this->name,
            'icon' => $this->icon,
            'class' => css_classes([
                $this->buttonClass(),
                $class => $class,
            ]),
        ]));
    }
}
