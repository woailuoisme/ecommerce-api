<?php

use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = max((int)$this->command->ask('How many address would you like?', 50), 1);
        $users = \App\User::all();
        factory(\App\Models\Address::class, $count)->make()->each(function ($address)use($users) {
            $address->user_id = $users->random()->id;
            $address->save();
        });

    }
}
