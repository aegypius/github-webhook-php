<?php
namespace GithubWebhook\Structure;

class People implements StructureInterface
{
    public $email;
    public $name;

    static public function fromJSON($json)
    {
        return self::fromArray(json_decode($json, true));
    }

    static public function fromArray($array)
    {
        $people = new People;
        foreach ($array as $k => $v) {
            $people->$k = $v;
        }
        return $people;
    }
}
