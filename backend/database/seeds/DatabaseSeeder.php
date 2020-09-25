<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ProductCategorySeeder::class);
         $this->call(StoreCategorySeeder::class);
         $this->call(CountryAndCitySeeder::class);
         $this->call(FaqSeeder::class);
         $this->call(PlattformFeesSeeder::class);
         $this->call(DemoUserSeeder::class);
     //    $this->call(FakeDataSeeder::class);
    }

}