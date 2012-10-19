<?php
namespace GithubWebhook\Structure;

class Commit implements StructureInterface
{
    public $id;
    public $message;
    public $timestamp;
    public $url;
    public $added = array();
    public $removed = array();
    public $modified = array();
    public $author;

    static public function fromJSON($json)
    {
        return self::fromArray(json_decode($json, true));
    }

    static public function fromArray($array)
    {
        $commit = new Commit;
        foreach ($array as $k => $v) {
            if ($k == 'author') {
                $v = People::fromJSON(json_encode($v));
            }
            $commit->$k = $v;
        }
        return $commit;
    }

}
