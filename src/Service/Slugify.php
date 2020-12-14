<?php

namespace App\Service;

class Slugify
{
    public function generate(string $input): string
    {
        $input = str_replace('à', 'a', $input);
        $input = str_replace('ç', 'c', $input);
        return mb_strtolower(preg_replace(array('/[^a-zA-Z0-9 \'-]/', '/[ -\']+/', '/^-|-$/'), array('', '-', ''), $input));

    }
}