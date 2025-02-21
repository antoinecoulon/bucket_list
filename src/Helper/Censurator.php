<?php

namespace App\Helper;

class Censurator
{
    public function purify(String $string): string
    {
        $grossier = ["merde", "con"]; // Liste des mots interdits en minuscules
        $pattern = '/\b(' . implode('|', array_map('preg_quote', $grossier)) . ')\b/i';
        return preg_replace($pattern, '*****', $string);
    }
}