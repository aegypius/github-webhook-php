<?php
namespace GithubWebhook\Structure;

class Payload implements StructureInterface
{
    public $ref;
    public $before;
    public $after;
    public $commits = array();
    public $repository;

    static function fromJSON($json)
    {
        return self::fromArray(json_decode($json, true));
    }

    static function fromArray($array)
    {
        $payload = new Payload;
        foreach ($array as $key => $value) {
            switch ($key) {
                case 'commits' : {
                    foreach ($value as $k => $v) {
                        $payload->commits []= Commit::fromArray($v);
                    }
                    break;
                }
                case 'repository' : {
                    $payload->repository = Repository::fromArray($value);
                    break;
                }
                default: {
                    $payload->$key = $value;
                }
            }
        }
        return $payload;
    }
}
