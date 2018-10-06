<?php

use Illuminate\Database\Seeder;
use App\MarxRelationship;
use App\MarxUser;
use App\MarxRelationshipType;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');

        $deleteUser = MarxUser::where('id', '>', '0')->delete();

        $user = new MarxUser;
        $user->name = 'Florian';
        $user->email = 'kingdomflo16@gmail.com';
        $user->auth0_id = '5b8bcdb84b3e140de3010e77';
        $user->save();

        $this->command->info('User table seeded!');
    }
}
