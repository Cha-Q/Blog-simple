<?php

    namespace App\helpers;


    class Text {
        public static function excerpt(string $content, int $limit = 60)
        {
            if(mb_strlen($content) <= $limit){
                return $content;
            }
            $lastSpace = mb_strpos($content, ' ', $limit);
            $lastBr = mb_strpos($content, "\r\n", 1);

            if ($lastBr != false){
                return mb_substr($content, 0, $lastBr) . ' ...';
            }
            return mb_substr($content, 0, $lastSpace) . ' ...';
        }
    }