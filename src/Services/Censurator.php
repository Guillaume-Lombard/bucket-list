<?php


namespace App\Services;


class Censurator
{


    public function purify($string){

        $tabBadWord = [
            'merde' => '*****',
            'con'   => '***',
        ];

        foreach ($tabBadWord as $key => $value ){
            $string = str_replace($key, $value, $string);
        }

        return $string;
    }

}