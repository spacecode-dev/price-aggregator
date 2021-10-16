<?php

namespace App\Http;

class Helper
{
    /**
     * @param $array
     * @return array
     */
    public static function flipAssociativeArray($array)
    {
        $new = [];
        foreach ($array as $key => $value) {
            if(is_array($value)) {
                $new[$key] = self::flipAssociativeArray($value);
            } else {
                $new[$value] = $key;
            }
        }
        return $new;
    }

    /**
     * @param $response
     * @return array
     */
    public static function responseJsonToArray($response)
    {
        return json_decode($response, true);
    }
}