<?php

namespace GithubWebhook;

class Util
{
    static function camelize($string, $camelizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(preg_replace('/-_/', ' ', $string)));
        if (!$camelizeFirstCharacter) {
            $str = lcfirst($str);
        }
        return $str;
    }
}
