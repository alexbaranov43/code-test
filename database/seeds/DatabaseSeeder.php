<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'first_name' => 'George',
            'last_name' => 'Washington',
            'is_subscribed' => '1',
            'email' => 'GDubz@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Alex',
            'last_name' => 'Baranov',
            'is_subscribed' => '1',
            'email' => 'alexbaranov43@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Joe',
            'last_name' => 'Schmoe',
            'is_subscribed' => '1',
            'email' => 'JoeSchmoe@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Tyler',
            'last_name' => 'Durden',
            'is_subscribed' => '1',
            'email' => 'TDurdenFC@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Random',
            'last_name' => 'Guy',
            'is_subscribed' => '1',
            'email' => 'RGuy@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('products')->insert([
            'user_id' => 1,
            'name' => 'Gravel Bike',
            'description' => '54 cm Cannondale Topstone 105',
            'price' => 1750,
            'image' =>  'https://www.sefiles.net/images/library/large/cannondale-topstone-105-366073-1.png',
            'is_available' => 1,
        ]);
                
        DB::table('products')->insert([
            'user_id' => 2,
            'name' => 'Road Bike',
            'description' => '56 cm Bianchi Impulso',
            'price' => 1600,
            'image' =>  'https://i.ytimg.com/vi/MqOQ1nV-h5A/maxresdefault.jpg',
            'is_available' => 0,
            'taken_by' => 2
        ]);

        DB::table('products')->insert([
            'user_id' => 3,
            'name' => 'Hybrid Bike',
            'description' => '55 cm Trek Dual Sport',
            'price' => 1100,
            'image' =>  'https://static.evanscycles.com/production/bikes/hybrid-bikes/product-image/484-319/trek-dual-sport-3-green-EV340578-6000-2.jpg',
            'is_available' => 1,
        ]);

        DB::table('products')->insert([
            'user_id' => 4,
            'name' => 'Gravel Bike',
            'description' => '56 cm Cinelli Zydeeco Full Color',
            'price' => 2200,
            'image' =>  'https://cdn11.bigcommerce.com/s-1hf4tfjzyx/images/stencil/600x600/products/2971/2489/zydeco_HIGH__36740.1544736165.jpg?c=2',
            'is_available' => 0,
            'taken_by' => 2,
        ]);
    }
}
