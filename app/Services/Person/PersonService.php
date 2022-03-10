<?php
/**
 * Created by PhpStorm.
 * User: murillo.morais
 * Date: 16/08/2021
 * Time: 17:40
 */

namespace App\Services\Person;


use App\Models\Company;
use App\Models\Person;
use Ramsey\Uuid\Uuid;


abstract class PersonService
{


    public static function store($data)
    {
        $person = new Person();
        $person->person_uuid             = Uuid::uuid4()->toString();
        $person->name             = $data['name'];
        $person->document         = $data['document'];
        $person->email            = $data['email'];

        $person->save();

        return $person;

    }
}
