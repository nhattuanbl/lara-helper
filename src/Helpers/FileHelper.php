<?php

namespace Nhattuanbl\LaraHelper\Helpers;

class FileHelper
{
    public static function byte2Readable(int|float $size): string
    {
        $unit = ['b','kb','mb','gb','tb','pb'];
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2) . ' ' . $unit[$i];
    }
}
