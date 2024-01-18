<?php

namespace Nhattuanbl\LaraHelper\Helpers;

class FileHelper
{
    public static function byte2Readable(int|float $size): string
    {
        $unit = ['b','kb','mb','gb','tb','pb'];
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2) . ' ' . $unit[$i];
    }

    public static function chmod_r(string $filename, int $permissions): void
    {
        $dir = new \DirectoryIterator($filename);
        foreach ($dir as $item) {
            chmod($item->getPathname(), $permissions);
            if ($item->isDir() && !$item->isDot()) {
                self::chmod_r($item->getPathname(), $permissions);
            }
        }
    }

    public static function chown_r(string $filename, string|int $user): void
    {
        $dir = new \DirectoryIterator($filename);
        foreach ($dir as $item) {
            chown($item->getPathname(), $user);
            if ($item->isDir() && !$item->isDot()) {
                self::chown_r($item->getPathname(), $user);
            }
        }
    }

    public static function chgrp_r(string $filename, string|int $group): void
    {
        $dir = new \DirectoryIterator($filename);
        foreach ($dir as $item) {
            chown($item->getPathname(), $group);
            if ($item->isDir() && !$item->isDot()) {
                self::chgrp_r($item->getPathname(), $group);
            }
        }
    }
}
