<?php

namespace App;
class Spam
{
    public function detect($body)
    {
        $this->detectInvalidKeywords($body);

        return false;
    }

    public function detectInvalidKeywords($body)
    {
        $invalidKeys = [
            'Yahoo Customer Support',
        ];

        foreach ($invalidKeys as $keyword) {
            if(stripos($body, $keyword) !== false) {
                throw new \Exception('Your body contains spam');
            }

        }
    }
}