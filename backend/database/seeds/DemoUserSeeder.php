<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\Admin;
use App\Models\UserWallet;
use App\Models\Cart;
use App\Models\UserBankInfo;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin =  new Admin();
        $admin->name = "Fb Admin";
        $admin->email = 'admin@freeback.com';
        $admin->password = Hash::make('password');
        $admin->save();


     /*   $user = new User();
        $user->name = "User Freeback";
        $user->email = "user@fb.com";
        $user->password = Hash::make('password');
        $user->phone_no = mt_rand(123456789,123456789);
        $user->active_until = \Illuminate\Support\Carbon::now()->addYear();
        $user->city_id = 1;
        $user->email_verify_token = str_random(100);
        $user->phone_verify_token = "1234";
        $user->own_referral_code = "U-12345678";
        $user->api_token = str_random(128);
        $user->avatar_url = "images/defaults/user.jpg";
        $user->save();

        $wallet = new UserWallet();
        $wallet->user_id = $user->id;
        $wallet->save();

        $store =  new Store();
        $store->email = "store@fb.com";
        $store->password = bcrypt("password");
        $store->business_name = "SuperStore SRL";
        $store->vat_number = "123456789";
        $store->email_verify_code = str_random(140);
        $store->phone_number = "12345852123";

        $store->website = "www.site.com";
        $store->store_category_id = 2;
        $store->store_type = "both";
        $store->street_address = "Via di Roma 33, Ravenna, Italy";
        $store->own_referral_code = 'S-12345678';
        $store->permalink = "store-srl-ravenna-cashback";
        $store->fb_fee = 1;

        $store->lat = 12345678.98;
        $store->lng = 98765432.01;


        $store->save();*/


    }
}
