<?php

use Illuminate\Database\Seeder;
use App\Models\FeesInfo;

class PlattformFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plattformFees = FeesInfo::create([
            'user_import' => 0,
            'store_import' => 0.00,
            'royalty_fee' => 10.00,
            'transaction_import' => 30.00,
            'minimum_requestable_import' => 10.00,
            'country_id' => 1,
        ]);
    }
}
