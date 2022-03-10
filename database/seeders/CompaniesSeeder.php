<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'company_uuid' => Uuid::uuid4()->toString(),
            'name' => 'Valepay Brasil LTDA',
            'fantasy_name' => 'Valepay Brasil LTDA',
            'document' => '28220872000184',
            'external_uuid' => Uuid::uuid4()->toString(),
            'email' => "administrativo@valepay.com.br",
            'person_id' => 1,
        ]);
    }
}
