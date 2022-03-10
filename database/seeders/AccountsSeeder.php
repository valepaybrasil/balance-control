<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('accounts')->insert([
            [
                'account_uuid' => "42f5749f-ecc6-41d2-be43-1c2d8de3d5da",
                'person_id' => null,
                'company_id' => 1,
                'is_active' => true,
                'account_name' => 'TAX_TED_DOC',
            ],
            [
                'account_uuid' => "42f5749f-ecc6-41d2-be43-1c2d8de3d5db",
                'person_id' => null,
                'company_id' => 1,
                'is_active' => true,
                'account_name' => 'TAX_PIX',

            ],
            [
                'account_uuid' => "42f5749f-ecc6-41d2-be43-1c2d8de3d5dc",
                'person_id' => null,
                'company_id' => 1,
                'is_active' => true,
                'account_name' => 'TAX_BILLIT',

            ]

        ]);
    
    }
}
