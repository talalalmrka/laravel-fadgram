<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteImage;
use App\Services\ImageService;
use Illuminate\Http\Request;

class QuoteImageController extends Controller
{

    public function index(Request $request)
    {
        $image = ImageService::fromRequest($request);
        $format = $request->get('format', 'jpeg');
        return response($image)->header('Content-Type', "image/$format");
    }
    public function quoteImage(Request $request, QuoteImage $quoteImage)
    {
        $image = ImageService::generate(array_merge($request->all(), [
            'img' => $quoteImage->image_path,
        ]));
        $format = $request->get('format', 'jpeg');
        return response($image)->header('Content-Type', "image/$format");
    }

    public function quote(Quote $quote, QuoteImage $quoteImage, $size = 'full', $format = 'jpg')
    {
        return response(ImageService::forQuote($quote, $quoteImage, $size === 'full' ? null : $size))->header('Content-Type', "image/$format");
    }
    public function preview(QuoteImage $quoteImage, $size = 'full', $format = 'jpg')
    {
        return response(ImageService::preview($quoteImage, $size === 'full' ? null : $size))->header('Content-Type', "image/$format");
    }

    public function random(Request $request)
    {
        $quoteImage = QuoteImage::inRandomOrder()->first();
        $image = ImageService::generate(array_merge($request->all(), [
            'img' => $quoteImage->image_path,
        ]));
        $format = $request->get('format', 'jpeg');
        return response($image)->header('Content-Type', "image/$format");
    }
}
