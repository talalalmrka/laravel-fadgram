<?php

namespace App\Services;

use App\Models\Quote;
use App\Models\QuoteImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\EncodedImageInterface;
use Intervention\Image\Typography\FontFactory;


class ImageService
{
    public static function generate($options = [], $size = null): EncodedImageInterface
    {
        $ops = collect($options);
        $text = $ops->get('text');
        $subText = $ops->get('subtext');
        $img = $ops->get('img', QuoteImage::first()?->image_path);
        $bg = $ops->get('bg', 'ccc');
        $fontFile = $ops->get('font', public_path('assets/fonts/Poppins-Regular.ttf'));
        $fontFile = self::validateFont($fontFile);
        $color = $ops->get('color', 'fff');
        $borderColor = $ops->get('border_color', '000');
        $borderWidth = intval($ops->get('border_width', 1));
        $width = intval($ops->get('width', 1200));
        $height = intval($ops->get('height', 630));
        $minFontSize = intval($ops->get('min_font', 10));
        $maxFontSize = intval($ops->get('max_font', 100));
        $lineSpacing = $ops->get('spacing', 1.7);
        $maxLines = intval($ops->get('max_lines', 7));
        $padding = intval($ops->get('padding', 30));
        $format = $ops->get('format', 'jpg');
        $logo = $ops->get('logo', logo_light_path() ?? Logo_path());
        $logoHeightPercent = intval($ops->get('logo_height', 10));
        $logoPosition = $ops->get('logo_position', 'bottom-left');
        $logoOffsetX = intval($ops->get('logo_offset_x', 10));
        $logoOffsetY = intval($ops->get('logo_offset_y', 10));
        $logoOpacity = intval($ops->get('logo_opacity', 100));
        $align = $ops->get('align', 'center');
        $valign = $ops->get('valign', 'middle');
        $quality = intval($ops->get('quality', 100));
        $blur = intval($ops->get('blur', 0));
        $sizes = [
            'md' => 0.7,
            'sm' => 0.5,
            'xs' => 0.25,
        ];
        if (!empty($size)) {
            $sizePercent = data_get($sizes, $size);
            if ($sizePercent) {
                $width = intval($width * $sizePercent);
                $height = intval($height * $sizePercent);
                $padding = intval($padding * $sizePercent);
                $maxFontSize = intval($maxFontSize * $sizePercent);
                // $borderWidth = intval($borderWidth * $sizePercent);
            }
        }
        $manager = new ImageManager(new Driver());
        $image = null;
        if (File::exists($img)) {
            try {
                $image = $manager->read($img);
            } catch (\Exception $e) {
            }
        }
        if (!$image) {
            $image = $manager->create($width, $height)->fill($bg);
        }
        if ($blur) {
            $image->blur($blur);
        }
        $image->resize($width, $height);
        if ($logo && File::exists($logo)) {
            try {
                $logoImage = $manager->read($logo);
                $recommendedLogoHeight = min(intval($image->height() / $logoHeightPercent), $logoImage->height());
                $logoHeight = $recommendedLogoHeight > 0 ? $recommendedLogoHeight : 30;
                $logoWidth = intval($logoImage->width() * ($logoHeight / $logoImage->height()));
                $logoImage = $logoImage->resize($logoWidth, $logoHeight);
                $image->place($logoImage, $logoPosition, $logoOffsetX, $logoOffsetY, $logoOpacity);
            } catch (\Exception $e) {
            }
        }
        $maxWidth = $width - ($padding * 2);
        $maxHeight = $height;
        $subTextHeight = 0;
        // Find the largest font size that fits
        $fontSize = self::getFontSize($text ?? '', $fontFile, $minFontSize, $maxFontSize, $maxWidth, $maxHeight, $padding, $lineSpacing);
        if ($subText) {
            $subTextFontSize = $fontSize * 0.6 > $minFontSize ? $fontSize * 0.6 : $minFontSize;
            $subTextHeight = self::getTextHeight($subText, $fontFile, $subTextFontSize, $maxWidth, $padding, 0);
            $maxHeight = $maxHeight - $subTextHeight;
            $fontSize = self::getFontSize($text ?? '', $fontFile, $minFontSize, $maxFontSize, $maxWidth, $maxHeight, $padding, $lineSpacing);
        }
        if ($text) {
            $image->text($text, $width / 2, $height / 2, function (FontFactory $font) use ($fontFile, $fontSize, $color, $borderColor, $borderWidth, $align, $valign, $width, $padding, $lineSpacing, $maxWidth) {
                $font->filename($fontFile);
                $font->size($fontSize);
                $font->color($color);
                if (!empty($borderWidth) && $borderWidth > 0) {
                    $font->stroke($borderColor, $borderWidth);
                }
                $font->wrap($maxWidth);
                $font->lineHeight($lineSpacing);
                $font->align($align);
                $font->valign($valign);
            });
        }
        if ($subText) {
            $subTextFontSize = $fontSize * 0.6 > $minFontSize ? $fontSize * 0.6 : $minFontSize;
            $textHeight = self::getTextHeight($text ?? '', $fontFile, $fontSize, $width, $padding, $lineSpacing);
            // dd($textHeight);
            $subTextX = $width / 2;
            $subTextHeight = self::getTextHeight($subText, $fontFile, $subTextFontSize, $maxWidth, $padding, 0);
            // $subTextY = $height - $padding;
            $subTextY = ($height / 2) + ($textHeight / 2) + 10;
            $image->text($subText, $subTextX, $subTextY, function (FontFactory $font) use ($fontFile, $subTextFontSize, $color, $borderColor, $borderWidth, $align, $valign) {
                $font->filename($fontFile);
                $font->size($subTextFontSize);
                $font->color($color);
                if (!empty($borderWidth) && $borderWidth > 0) {
                    $font->stroke($borderColor, $borderWidth);
                }
                $font->align('center');
                $font->valign('middle');
            });
        }
        return match ($format) {
            'jpg' => $image->toJpeg($quality),
            'jpeg' => $image->toJpeg($quality),
            'jpeg2000' => $image->toJpeg2000($quality),
            'avif' => $image->toAvif($quality),
            'png' => $image->toPng($quality),
            'tiff' => $image->toTiff($quality),
            'gif' => $image->toGif($quality),
            'bitmap' => $image->toBitmap($quality),
            'webp' => $image->toWebp($quality),
            default => $image->toJpeg($quality),
        };
    }
    public static function getTextHeight(
        string $text,
        string $fontFile,
        int $fontSize,
        int $maxWidth,
        int $padding,
        int $lineSpacing
    ): int {
        // 1. Wrap the text roughly the same way Intervention does
        //    (this simple word‑wrap may differ slightly, but is usually close).
        $wrapped = wordwrap($text, floor(($maxWidth - 2 * $padding) / ($fontSize * 0.6)), "\n", true);
        $lines   = explode("\n", $wrapped);
        $numLines = count($lines);

        // 2. Use imagettfbbox to measure one line's height
        //    bbox[1] = y‑coordinate of baseline, bbox[5] = top y‑coordinate
        $bbox = imagettfbbox($fontSize, 0, $fontFile, 'Ay');
        $lineHeightPx = abs($bbox[5] - $bbox[1]);

        // 3. Total text height = sum of line heights + inter‑line spacing
        $textHeight = $lineHeightPx * $numLines
            + $lineSpacing * ($numLines - 1);

        // 4. Add vertical padding
        return $textHeight + ($padding * 2);
    }
    public static function getFontSize(
        string $text,
        string $fontFile,
        int    $minFontSize,
        int    $maxFontSize,
        int    $maxWidth,
        int    $maxHeight,
        int    $padding,
        int    $lineSpacing
    ): int {
        $low  = $minFontSize;
        $high = $maxFontSize;
        $best = $minFontSize;

        while ($low <= $high) {
            $mid = (int) floor(($low + $high) / 2);

            $h = self::getTextHeight(
                $text,
                $fontFile,
                $mid,
                $maxWidth,
                $padding,
                $lineSpacing
            );

            if ($h <= $maxHeight) {
                // it fits, try a larger size
                $best = $mid;
                $low  = $mid + 1;
            } else {
                // too tall, go smaller
                $high = $mid - 1;
            }
        }
        return $best;
    }
    public static function generatee($options = [], $size = null): EncodedImageInterface
    {
        $ops = collect($options);
        $text = $ops->get('text', fake()->paragraph(1));
        $subText = $ops->get('subtext', fake()->words(2, true));
        $img = $ops->get('img', QuoteImage::first()?->image_path);
        $bg = $ops->get('bg', 'ccc');
        $fontFile = $ops->get('font', public_path('assets/fonts/Poppins-Regular.ttf'));
        $fontFile = self::validateFont($fontFile);
        $color = $ops->get('color', 'fff');
        $borderColor = $ops->get('border_color', '000');
        $borderWidth = intval($ops->get('border_width', 1));
        $width = intval($ops->get('width', 1200));
        $height = intval($ops->get('height', 630));
        $minFontSize = intval($ops->get('min_font', 10));
        $maxFontSize = intval($ops->get('max_font', 80));
        $lineSpacing = $ops->get('spacing', 1.7);
        $maxLines = intval($ops->get('max_lines', 7));
        $padding = intval($ops->get('padding', 30));
        $format = $ops->get('format', 'jpg');
        $logo = $ops->get('logo', logo_light_path() ?? Logo_path());
        $logoHeightPercent = intval($ops->get('logo_height', 10));
        $logoPosition = $ops->get('logo_position', 'bottom-left');
        $logoOffsetX = intval($ops->get('logo_offset_x', 10));
        $logoOffsetY = intval($ops->get('logo_offset_y', 10));
        $logoOpacity = intval($ops->get('logo_opacity', 100));
        $align = $ops->get('align', 'center');
        $valign = $ops->get('valign', 'bottom');
        $quality = intval($ops->get('quality', 100));
        $blur = intval($ops->get('blur', 0));
        $sizes = [
            'md' => 0.7,
            'sm' => 0.5,
            'xs' => 0.25,
        ];
        if (!empty($size)) {
            $sizePercent = data_get($sizes, $size);
            if ($sizePercent) {
                $width = intval($width * $sizePercent);
                $height = intval($height * $sizePercent);
                $padding = intval($padding * $sizePercent);
                $maxFontSize = intval($maxFontSize * $sizePercent);
                // $borderWidth = intval($borderWidth * $sizePercent);
            }
        }
        $manager = new ImageManager(new Driver());
        $image = null;
        if (File::exists($img)) {
            try {
                $image = $manager->read($img);
            } catch (\Exception $e) {
            }
        }
        if (!$image) {
            $image = $manager->create($width, $height)->fill($bg);
        }
        if ($blur) {
            $image->blur($blur);
        }
        $image->resize($width, $height);
        if ($logo && File::exists($logo)) {
            try {
                $logoImage = $manager->read($logo);
                $recommendedLogoHeight = min(intval($image->height() / $logoHeightPercent), $logoImage->height());
                $logoHeight = $recommendedLogoHeight > 0 ? $recommendedLogoHeight : 30;
                $logoWidth = intval($logoImage->width() * ($logoHeight / $logoImage->height()));
                $logoImage = $logoImage->resize($logoWidth, $logoHeight);
                $image->place($logoImage, $logoPosition, $logoOffsetX, $logoOffsetY, $logoOpacity);
            } catch (\Exception $e) {
            }
        }
        // Helper function for wrapping with max lines support
        /* $wrapTextToWidth = function ($text, $fontFile, $fontSize, $maxWidth, $maxLines = 0) {
            $words = explode(' ', $text);
            $lines = [];
            $currentLine = '';
            $lineCount = 0;

            foreach ($words as $word) {
                $testLine = $currentLine ? $currentLine . ' ' . $word : $word;
                $bbox = imagettfbbox($fontSize, 0, $fontFile, $testLine);
                $lineWidth = abs($bbox[2] - $bbox[0]);

                if ($lineWidth > $maxWidth && $currentLine) {
                    $lineCount++;
                    if ($maxLines > 0 && $lineCount >= $maxLines) {
                        // Add ellipsis if truncated
                        $bbox = imagettfbbox($fontSize, 0, $fontFile, $currentLine . '...');
                        if (abs($bbox[2] - $bbox[0]) <= $maxWidth) {
                            $currentLine .= '...';
                        }
                        $lines[] = $currentLine;
                        return $lines;
                    }

                    $lines[] = $currentLine;
                    $currentLine = $word;
                } else {
                    $currentLine = $testLine;
                }
            }

            if ($currentLine) {
                $lines[] = $currentLine;
            }
            return $lines;
        }; */

        // Find the largest font size that fits
        $fontSize = $maxFontSize;
        $lines = [];
        $lineHeights = [];
        $textBlockHeight = 0;
        if ($text) {
            while ($fontSize >= $minFontSize) {
                // $lines = $wrapTextToWidth($text, $fontFile, $fontSize, $width - ($padding * 2), $maxLines);
                $lines = self::getLines($text, $fontFile, $fontSize, $width - ($padding * 2), $maxLines);

                $lineHeights = [];
                $textBlockHeight = 0;

                foreach ($lines as $i => $line) {
                    $bbox = imagettfbbox($fontSize, 0, $fontFile, $line);
                    $ascent = abs($bbox[7]); // Distance from baseline to top
                    $descent = abs($bbox[1]); // Distance from baseline to bottom
                    $lineHeights[$i] = ['ascent' => $ascent, 'descent' => $descent];

                    // First line: full height
                    if ($i === 0) {
                        $textBlockHeight += $ascent;
                    }

                    // Last line: add descent
                    if ($i === count($lines) - 1) {
                        $textBlockHeight += $descent;
                    }

                    // Add spacing for all lines except last
                    if ($i < count($lines) - 1) {
                        $textBlockHeight += ($ascent * $lineSpacing);
                    }
                }
                if ($subText) {
                    $subbbox = imagettfbbox($fontSize / 2, 0, $fontFile, $subText);
                    $subascent = abs($subbbox[7]); // Distance from baseline to top
                    $subdescent = abs($subbbox[1]); // Distance from baseline to bottom
                    $lineHeights[$i] = ['ascent' => $subascent, 'descent' => $subdescent];
                    $textBlockHeight += ($subascent * $lineSpacing) * 2;
                }
                if ($textBlockHeight <= $height - ($padding * 2)) {
                    break;
                }
                $fontSize--;
            }

            // Calculate vertical start position (centered baseline)
            $baselineY = ($height - $textBlockHeight) / 2 + $lineHeights[0]['ascent'];

            // Draw each line with precise centering
            foreach ($lines as $i => $line) {
                $image->text($line, $width / 2, $baselineY, function (FontFactory $font) use ($fontFile, $fontSize, $color, $borderColor, $borderWidth, $align, $valign) {
                    $font->filename($fontFile);
                    $font->size($fontSize);
                    $font->color($color);
                    if (!empty($borderWidth) && $borderWidth > 0) {
                        $font->stroke($borderColor, $borderWidth);
                    }
                    $font->align($align);
                    $font->valign($valign);
                });

                // Move to next baseline position
                if (isset($lineHeights[$i + 1])) {
                    $baselineY += $lineHeights[$i]['ascent'] * $lineSpacing;
                }
            }
        }
        if ($subText) {
            $subTextFontSize = $fontSize * 0.6 > $minFontSize ? $fontSize * 0.6 : $minFontSize;
            $subTextY = $height - ($padding + self::getTextHeight($subText, $fontFile, $subTextFontSize, $width, $padding, 0));
            // $subTextY = $textBlockHeight + self::getTextHeight($subTextFontSize, 0, $fontFile, $subText);
            $image->text($subText, $width / 2, $subTextY, function (FontFactory $font) use ($fontFile, $subTextFontSize, $color, $borderColor, $borderWidth, $align, $valign) {
                $font->filename($fontFile);
                $font->size($subTextFontSize);
                $font->color($color);
                if (!empty($borderWidth) && $borderWidth > 0) {
                    $font->stroke($borderColor, $borderWidth);
                }
                $font->align($align);
                $font->valign($valign);
            });
        }
        /* if (!empty($size)) {
            $sizePercent = data_get($sizes, $size);
            if ($sizePercent) {
                $width = intval($width * $sizePercent);
                $height = intval($height * $sizePercent);
                $image->resize($width, $height);
            }
        } */
        return match ($format) {
            'jpg' => $image->toJpeg($quality),
            'jpeg' => $image->toJpeg($quality),
            'jpeg2000' => $image->toJpeg2000($quality),
            'avif' => $image->toAvif($quality),
            'png' => $image->toPng($quality),
            'tiff' => $image->toTiff($quality),
            'gif' => $image->toGif($quality),
            'bitmap' => $image->toBitmap($quality),
            'webp' => $image->toWebp($quality),
            default => $image->toJpeg($quality),
        };
    }
    public static function validateFont($fontFile)
    {
        $text = fake()->paragraph(1);
        try {
            imagettfbbox(40, 0, $fontFile, $text);
            return $fontFile;
        } catch (Exception $e) {
            return public_path('assets/fonts/Poppins-Regular.ttf');
        }
    }
    public static function getLines($text, $fontFile, $fontSize, $maxWidth, $maxLines = 0)
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';
        $lineCount = 0;

        foreach ($words as $word) {
            $testLine = $currentLine ? $currentLine . ' ' . $word : $word;
            $bbox = imagettfbbox($fontSize, 0, $fontFile, $testLine);
            $lineWidth = abs($bbox[2] - $bbox[0]);

            if ($lineWidth > $maxWidth && $currentLine) {
                $lineCount++;
                if ($maxLines > 0 && $lineCount >= $maxLines) {
                    // Add ellipsis if truncated
                    $bbox = imagettfbbox($fontSize, 0, $fontFile, $currentLine . '...');
                    if (abs($bbox[2] - $bbox[0]) <= $maxWidth) {
                        $currentLine .= '...';
                    }
                    $lines[] = $currentLine;
                    return $lines;
                }

                $lines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }

        if ($currentLine) {
            $lines[] = $currentLine;
        }
        return $lines;
    }

    public static function getTextHeightt($fontSize, $angle, $fontFile, $text)
    {
        $box = imagettfbbox($fontSize, $angle, $fontFile, $text);

        // Extract all y-coordinates
        $ys = [
            $box[1],
            $box[3],
            $box[5],
            $box[7],
        ];

        // Calculate height: max Y minus min Y
        $height = max($ys) - min($ys);

        // Return positive integer
        return (int) abs($height);
    }
    public static function fromRequest(Request $request): EncodedImageInterface
    {
        return self::generate($request->all(), $request->get('size'));
    }

    public static function forQuote(Quote $quote, QuoteImage $quoteImage, $size = null): EncodedImageInterface
    {
        return self::generate($quoteImage->generateOptions([
            'text' => $quote->content,
            'subtext' => $quote->author_name,
        ]), $size);
    }
    public static function preview(QuoteImage $quoteImage, $size = null): EncodedImageInterface
    {
        return self::generate($quoteImage->generateOptions([
            'text' => '',
            'subtext' => '',
            'logo' => null,
        ]), $size);
    }
}
