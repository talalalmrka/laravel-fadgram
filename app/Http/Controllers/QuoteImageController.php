<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteImage;
use App\Services\ImageService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class QuoteImageController extends Controller
{
    public $disk;
    public $folder;
    public FileSystem $storage;

    public function __construct()
    {
        $this->disk = config('imgen.disk_name');
        $this->folder = config('imgen.folder');
        $this->storage = Storage::disk($this->disk);
    }

    public function index(Request $request)
    {
        $options = ImageService::options($request->all());
        $format = $options->get('format');
        $encodedOptions = md5(json_encode($options->toArray()));
        $key = "imgen:$encodedOptions";
        $fileName = "{$this->folder}/{$encodedOptions}.{$format}";
        $ttl = intval($request->get('ttl', 60 * 60 * 24));
        $path = Cache::remember($key, $ttl, function () use ($request, $fileName) {
            $imageData = ImageService::fromRequest($request);
            $this->storage->put($fileName, $imageData);
            return $this->storage->path($fileName);
        });
        if (!File::exists($path)) {
            Cache::forget($key);
            return response()->json(['error' => 'Image file not found.'], 404);
        }

        $mimeType = File::mimeType($path);
        return Response::file($path, [
            'Content-Type' => $mimeType,
            // 'Cache-Control' => "max-age=$ttl, public",
        ]);
    }

    public function quote(Request $request, Quote $quote, QuoteImage $quoteImage, $size = 'full', $format = 'jpg')
    {
        $options = ImageService::options([
            ...$request->all(),
            ...$quoteImage->generateOptions([
                'text' => $quote->content,
                'subtext' => $quote->author_name,
                'size' => $size,
                'format' => $format,
            ]),
        ]);
        $format = $options->get('format');
        $encodedOptions = md5(json_encode($options->toArray()));
        $key = "imgen:$encodedOptions";
        $fileName = "{$this->folder}/{$quote->id}-{$quoteImage->id}-{$size}.{$format}";
        $ttl = intval($request->get('ttl', 60 * 60 * 24));
        $path = Cache::remember($key, $ttl, function () use ($quote, $quoteImage, $size, $fileName) {
            $imageData = ImageService::forQuote($quote, $quoteImage, $size);
            $this->storage->put($fileName, $imageData);
            return $this->storage->path($fileName);
        });
        if (!File::exists($path)) {
            Cache::forget($key);
            return response()->json(['error' => 'Image file not found.'], 404);
        }
        $mimeType = File::mimeType($path);
        return Response::file($path, [
            'Content-Type' => $mimeType,
            // 'Cache-Control' => "max-age=$ttl, public",
        ]);
    }

    public function preview(Request $request, QuoteImage $quoteImage, $size = 'full', $format = 'jpg')
    {
        $options = ImageService::options([
            ...$request->all(),
            ...$quoteImage->generateOptions([
                'text' => null,
                'subtext' => null,
                'size' => $size,
                'format' => $format,
            ]),
        ]);
        $format = $options->get('format');
        $encodedOptions = md5(json_encode($options->toArray()));
        $key = "imgen:$encodedOptions";
        $fileName = "{$this->folder}/{$quoteImage->id}-{$size}.{$format}";
        $ttl = intval($request->get('ttl', 60 * 60 * 24));
        $path = Cache::remember($key, $ttl, function () use ($quoteImage, $size, $fileName) {
            $imageData = ImageService::preview($quoteImage, $size);
            $this->storage->put($fileName, $imageData);
            return $this->storage->path($fileName);
        });
        if (!File::exists($path)) {
            Cache::forget($key);
            return response()->json(['error' => 'Image file not found.'], 404);
        }
        $mimeType = File::mimeType($path);
        return Response::file($path, [
            'Content-Type' => $mimeType,
            // 'Cache-Control' => "max-age=$ttl, public",
        ]);
    }

    public function quoteImage(Request $request, QuoteImage $quoteImage)
    {
        $options = ImageService::options([
            ...$request->all(),
            ...$quoteImage->generateOptions([
                'text' => null,
                'subtext' => null,
            ]),
        ]);
        $format = $options->get('format');
        $encodedOptions = md5(json_encode($options->toArray()));
        $key = "imgen:$encodedOptions";
        $fileName = "{$this->folder}/{$quoteImage->id}.{$format}";
        $ttl = intval($request->get('ttl', 60 * 60 * 24));
        $path = Cache::remember($key, $ttl, function () use ($request, $quoteImage, $fileName) {
            $imageData = ImageService::generate(array_merge($request->all(), [
                'img' => $quoteImage->image_path,
            ]));
            $this->storage->put($fileName, $imageData);
            return $this->storage->path($fileName);
        });
        if (!File::exists($path)) {
            Cache::forget($key);
            return response()->json(['error' => 'Image file not found.'], 404);
        }
        $mimeType = File::mimeType($path);
        return Response::file($path, [
            'Content-Type' => $mimeType,
            // 'Cache-Control' => "max-age=$ttl, public",
        ]);
    }

    public function quoteImages(Quote $quote)
    {
        return response()->json($quote->imagesResponse());
    }
    public function quoteRandom(Quote $quote)
    {
        return response()->json($quote->randomImagesResponse());
    }

    public function quoteDownload(Request $request, Quote $quote, QuoteImage $quoteImage, $size = 'full', $format = 'jpg')
    {
        $options = ImageService::options([
            ...$request->all(),
            ...$quoteImage->generateOptions([
                'text' => $quote->content,
                'subtext' => $quote->author_name,
                'size' => $size,
                'format' => $format,
            ]),
        ]);
        $format = $options->get('format');
        $encodedOptions = md5(json_encode($options->toArray()));
        $key = "imgen:$encodedOptions";
        $fileName = "{$this->folder}/{$quote->id}-{$quoteImage->id}-{$size}.{$format}";
        $ttl = intval($request->get('ttl', 60 * 60 * 24));
        $path = Cache::remember($key, $ttl, function () use ($quote, $quoteImage, $size, $fileName) {
            $imageData = ImageService::forQuote($quote, $quoteImage, $size);
            $this->storage->put($fileName, $imageData);
            return $this->storage->path($fileName);
        });
        if (!File::exists($path)) {
            Cache::forget($key);
            return response()->json(['error' => 'Image file not found.'], 404);
        }
        $mimeType = File::mimeType($path);
        $downloadFileName = basename($path);
        return Response::download($path, $downloadFileName, [
            'Content-Type' => $mimeType,
            // 'Cache-Control' => "max-age=$ttl, public",
        ]);
    }
}
