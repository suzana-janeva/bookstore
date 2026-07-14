<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PlaceholderCoverGenerator
{
    private const WIDTH = 400;

    private const HEIGHT = 600;

    private const BACKGROUND = [0x55, 0x40, 0xAF];

    private const TEXT_COLOR = [0xFF, 0xFF, 0xFF];

    public function generate(string $title): string
    {
        $path = 'covers/placeholders/'.md5($title).'.png';

        if (Storage::disk('public')->exists($path)) {
            return $path;
        }

        Storage::disk('public')->put($path, $this->render($title));

        return $path;
    }

    private function render(string $title): string
    {
        $image = imagecreatetruecolor(self::WIDTH, self::HEIGHT);
        $background = imagecolorallocate($image, ...self::BACKGROUND);
        $textColor = imagecolorallocate($image, ...self::TEXT_COLOR);
        imagefill($image, 0, 0, $background);

        $font = 5;
        $charWidth = imagefontwidth($font);
        $charHeight = imagefontheight($font);
        $maxCharsPerLine = max((int) floor((self::WIDTH - 40) / $charWidth), 1);

        $lines = $this->wrap($title, $maxCharsPerLine);
        $lineHeight = $charHeight + 6;
        $y = (int) ((self::HEIGHT - count($lines) * $lineHeight) / 2);

        foreach ($lines as $line) {
            $x = (int) ((self::WIDTH - strlen($line) * $charWidth) / 2);
            imagestring($image, $font, $x, $y, $line, $textColor);
            $y += $lineHeight;
        }

        ob_start();
        imagepng($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        return $contents;
    }

    private function wrap(string $title, int $maxChars): array
    {
        $words = preg_split('/\s+/', trim($title)) ?: [];
        $lines = [];
        $current = '';

        foreach ($words as $word) {
            $candidate = trim($current === '' ? $word : "{$current} {$word}");

            if (strlen($candidate) > $maxChars && $current !== '') {
                $lines[] = $current;
                $current = $word;
            } else {
                $current = $candidate;
            }
        }

        if ($current !== '') {
            $lines[] = $current;
        }

        return array_slice($lines, 0, 8);
    }
}
