<?php
namespace GithubWebhook\Structure;

interface StructureInterface
{

    static public function fromJSON($string);
    static public function fromArray($array);
}


