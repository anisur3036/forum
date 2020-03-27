<?php

namespace App;
class Spam
{
    public function detect()
    {
        $this->detectSpam();

        return false;
    }

    public function detectSpam()
    {
        $invalidKeys = [
            'Yahoo Customer',
        ];

        foreach ($invalidKeys as $keyword) {
            if(stripos(request('body'), 'yahoo customer') !== false) {
                throw new \Exception('Your body contains spam');
            }

        }
    }
}