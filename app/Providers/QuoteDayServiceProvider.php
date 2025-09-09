<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\QuoteDay;
use Carbon\Carbon;

class QuoteDayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->generate();
    }

    public function generate()
    {
        try {
            $today = Carbon::today();
            $quoteDays = QuoteDay::where('day', $today);
            if ($quoteDays->count()) {
                return;
            }
            // Get categories that have quotes
            $categories = Category::hasQuotes()->inRandomOrder()->limit(4)->get();
            if ($categories->isEmpty()) {
                return; // No categories with quotes found
            }

            // Loop through categories and set QuoteDay for today
            foreach ($categories as $category) {
                $quoteDayForCat = QuoteDay::where('category_id', $category->id)
                    ->where('created_at', $today)->first();
                if (!$quoteDayForCat) {
                    // Get random quote from this category
                    $randomQuote = $category->quotes()
                        ->where('status', 'publish')
                        ->inRandomOrder()
                        ->first();

                    if ($randomQuote) {
                        // Create QuoteDay for this category
                        QuoteDay::create([
                            'user_id' => current_user_id(),
                            'quote_id' => $randomQuote->id,
                            'category_id' => $category->id,
                            'day' => $today,
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
        }
    }
}
