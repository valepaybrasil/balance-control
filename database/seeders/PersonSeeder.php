<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Person::create([
            'person_uuid' => Uuid::uuid4()->toString(),
            'name' => 'Valepay Brasil LTDA',
            'document' => '28220872000184',
            'email' => "administrativo@valepay.com.br",
        ]);
    }
}
