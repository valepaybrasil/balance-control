<?php
/**
 * Created by PhpStorm.
 * User: murillo.morais
 * Date: 16/08/2021
 * Time: 17:40
 */

namespace App\Services\Company;


use App\Models\Company;
use App\Models\Person;
use Ramsey\Uuid\Uuid;


abstract class CompanyService
{


    public static function saveCompany($data, Person $person)
    {
        $company = new Company();
        $company->company_uuid      = Uuid::uuid4()->toString();
        $company->name             = $data['name'];
        $company->fantasy_name     = $data['fantasy_name'];
        $company->document         = $data['document'];
        $company->external_uuid    = $data['external_uuid'];
        $company->email            = $data['email'];
        $company->person_id        = $person->id;

        $company->save();

        return $company;

    }
}
