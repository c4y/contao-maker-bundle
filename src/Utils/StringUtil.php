<?php

namespace App\Utils;

class StringUtil
{
    public static function camel_to_snake($input)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }

    public static function camel_to_kebap($input)
    {
        $return = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $input));
        $return = str_replace('/-', '/', $return);

        return $return;
    }
}