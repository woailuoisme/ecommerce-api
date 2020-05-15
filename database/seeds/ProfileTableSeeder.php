<?php

use App\Models\Profile;
use App\User;
use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $users->each(function (User $user) {
//                dd(factory(Profile::class)->make());
            $user->profile()->save(
                factory(Profile::class)->make()
            );
        });
    }
}
