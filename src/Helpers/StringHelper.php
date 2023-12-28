<?php

namespace Nhattuanbl\LaraHelper\Helpers;

use Carbon\Carbon;

class StringHelper
{
    static function isJson(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public static function getValidEmail(?string $email): ?string
    {
        if (!$email) {
            return null;
        }

        $email = trim($email);
        $validator = validator(['email' => $email], ['email' => 'email']);
        if ($validator->failed() || !strlen($email)) {
            return null;
        }

        return $email;
    }

    public static function isDate($date): bool
    {
        if (!$date) {
            return false;
        }

        if (str_starts_with($date, '-') || str_starts_with($date, '000') ) {
            return false;
        }

        //check hell date
        //var_dump(is_date('2021/12/08 05:00:00'));
        //var_dump(is_date('2021-12-08 05:00:00'));
        //var_dump(is_date('00/00/00'));
        //var_dump(is_date('00-00-00'));
        //var_dump(is_date('00-00-00 00:00:00'));
        //var_dump(is_date('00/00/00 00:00:00'));
        //var_dump(is_date('00/00/00 00:00'));
        //var_dump(is_date('00/00/00 00:00:00'));
        //var_dump(is_date(null));
        //var_dump(is_date(true));
        //var_dump(is_date(''));
        if (preg_match_all('/^0+[\/\-\ :0]*$/', $date)) {
            return false;
        }

        $date = str_replace('/', '-', $date);
        if ((bool) strtotime($date)) {
            try {
                Carbon::parse($date);
            } catch (\Exception $e) {
                return false;
            }
        }

        return true;
    }

    public static function vi2Ascii(?string $str): string
    {
        if (!$str) return '';

        $utf8 = [
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ|Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        ];

        foreach ($utf8 as $ascii => $uni) $str = preg_replace("/($uni)/i",$ascii,$str);
        return $str;
    }
}
