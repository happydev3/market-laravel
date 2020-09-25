<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductMultimedia;
use App\Models\StoreReview;
use App\Models\StoreMultimedia;
use App\Models\StoreBranch;

class FakeDataSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        foreach(range(1,100) as $index){
            $store =  new Store();
            $store->email = str_random(40)."@".str_random(10).".com";
            $store->password = bcrypt('password');
            $store->business_name = $faker->company;
            $store->vat_number = mt_rand(10000000,99999999);
            $store->email_verify_code = str_random(140);
            $store->phone_number = mt_rand(100000000,999999999);
            $store->website = "https://".str_random(10).".com";
            $store->store_category_id = mt_rand(1,20);
            $store->store_type = "both";
            $store->referral_code = 'S-46653387';
            $store->own_referral_code = 'S-'.mt_rand(10000000,99999999);
            $store->permalink = $store->email."permalink".str_random(35);
            $store->freeback_rate =30.00;
            $store->save();

            StoreBranch::create([
                'street_address' => "Via di Roma 44, Ravenna, Italia",
                'store_id' => $store->id,
                'lat' => $faker->latitude,
                'lng' => $faker->longitude,
            ]);


            $storeMultimedia = new StoreMultimedia();
            $storeMultimedia->store_id = $store->id;
            $storeMultimedia->logo_url = "images/defaults/store.jpg";
            $storeMultimedia->front_image_thumbnail = "images/defaults/store_small.png";
            $storeMultimedia->landing_background_url = "images/defaults/store_bg.jpg";
            $storeMultimedia->mobile_thumb = "images/defaults/store_small.png";
            $storeMultimedia->save();


            $user = new \App\Models\User();
            $user->name = $faker->firstNameMale." ".$faker->lastName;
            $user->email = str_random(15)."@".str_random(10).".com";
            $user->password = Hash::make('password');
            $user->phone_no = str_random(9);
            $user->active_until = \Illuminate\Support\Carbon::now()->addYear();
            $user->city_id = 1;
            $user->email_verify_token = str_random(100);
            $user->phone_verify_token = str_random(4);
            $user->referral_code = "S-46653387";
            $user->own_referral_code = "U-".str_random(8);
            $user->api_token = str_random(128);
            $user->avatar_url = "images/defaults/user.jpg";
            $user->save();

            $wallet = new \App\Models\UserWallet();
            $wallet->user_id = $user->id;
            $wallet->save();
        }

       foreach(range(1,100) as $index){
            $product =  new Product();
            $product->title = $faker->text(20);
            $product->description = $faker->text(100);
            $product->product_category_id = mt_rand(2,22);
            $product->price = mt_rand(1,100);
            $product->quantity_available = mt_rand(1,100);
            $product->store_id = mt_rand(1,100);
            $product->slug = $product->title. "_".str_random(40);
            $product->save();

            $productMultimedia = new ProductMultimedia();
            $productMultimedia->type = "web_thumb";
            $productMultimedia->product_id = $product->id;
            $productMultimedia->url = "images/defaults/product_small.png";
            $productMultimedia->save();

            $productMultimedia = new ProductMultimedia();
            $productMultimedia->type = "image";
            $productMultimedia->product_id = $product->id;
            $productMultimedia->url = "images/defaults/product_big.png";
            $productMultimedia->save();
        }

     foreach(range(1,100) as $index) {
          $review =  new StoreReview();
          $review->store_id = mt_rand(1,450);
          $review->user_id = 1;
          $review->type = "positive";
          $review->review = $faker->text(350);
          $review->save();

          $review = new StoreReview();
          $review->store_id = mt_rand(1,100);
          $review->user_id = 1;
          $review->type = "negative";
          $review->review = $faker->text(128);
          $review->save();
      }

    }
}
