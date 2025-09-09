<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\ComponentAttributeBag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerDirectives();
    }
    protected function registerDirectives()
    {
        Blade::directive('menu', function ($expression) {
            $parts = explode(',', $expression, 2);
            $position = isset($parts[0]) ? trim($parts[0]) : "'default'";
            $attributes = isset($parts[1]) ? trim($parts[1]) : '[]';
            return <<<PHP
            <?php
            navMenu({$position}, {$attributes});
            ?>
            PHP;
        });
    }
}
