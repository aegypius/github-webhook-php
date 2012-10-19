<?php
namespace GithubWebhook\Structure;

class Repository implements StructureInterface
{
    public $name;
    public $url;
    public $pledgie;
    public $description;
    public $homepage;
    public $watchers = 0;
    public $forks = 0;
    public $private = 0;
    public $owner;

    static public function fromJSON($json)
    {
        return self::fromArray(json_decode($json, true));
    }

    static public function fromArray($array)
    {
        $repository = new Repository;
        foreach ($array as $k => $v) {
            if ($k == 'owner') {
                $v = People::fromJSON(json_encode($v));
            }
            $repository->$k = $v;
        }
        return $repository;
    }

}
