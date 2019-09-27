<?php

namespace App\Helpers;

class Highlight
{
    public static function show($input, $paramsSearch, $field){
        if($paramsSearch == "") return $input;
        if($paramsSearch['field'] == 'all' || $paramsSearch['field'] == $field){
            // return preg_replace("/".preg_quote($paramsSearch['value'], "/")."/i", "<span class='highlight'>". $paramsSearch['value'] ."</span>", $input);
            return str_ireplace($paramsSearch['value'], "<span class='highlight'>". $paramsSearch['value'] ."</span>", $input);
        }
        return $input;
    }
}