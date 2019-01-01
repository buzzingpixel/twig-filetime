<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2018 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\twigfiletime;

use Twig_Function;
use Twig_Extension;

class FileTimeTwigExtension extends Twig_Extension
{
    public function getFunctions(): array
    {
        return [new Twig_Function('fileTime', [$this, 'fileTime'])];
    }

    public function fileTime(string $filePath = '', $uniqidFallback = true): string
    {
        if (file_exists($filePath)) {
            return (string) filemtime($filePath);
        }

        $basePath = rtrim(
            defined('APP_BASE_PATH') ? APP_BASE_PATH : getcwd(),
            '/'
        );

        $filePath = ltrim($filePath, '/');
        $newPath = $basePath . '/' . $filePath;

        if (file_exists($newPath)) {
            return (string) filemtime($newPath);
        }

        $filePath = ltrim($filePath, '/');
        $newPath = $basePath . '/public/' . $filePath;

        if (file_exists($newPath)) {
            return (string) filemtime($newPath);
        }

        if ($uniqidFallback) {
            return uniqid('', false);
        }

        return '0';
    }
}
