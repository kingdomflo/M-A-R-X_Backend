<?php

use Illuminate\Database\Seeder;
use App\MarxRelationship;
use App\MarxUser;
use App\MarxRelationshipType;
use App\MarxUserRelationshipType;
use App\MarxCurrencies;
use App\MarxUserCurrencies;

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

        $user = new MarxUser;
        $user->name = 'kingdomflo16@gmail.com';
        $user->email = 'kingdomflo16@gmail.com';
        $user->auth0_id = 'auth0|5b8bcdb84b3e140de3010e77';
        $user->save();

        $relationshipType = new MarxRelationshipType();
        $relationshipType->name = 'Friend';
        $relationshipType->save();

        $relationshipType = new MarxRelationshipType();
        $relationshipType->name = 'Colleague';
        $relationshipType->save();

        $relationshipType = new MarxRelationshipType();
        $relationshipType->name = 'Family';
        $relationshipType->save();

        $userRelationshipType = new MarxUserRelationshipType();
        $userRelationshipType->user_id = 1;
        $userRelationshipType->relationship_type_id = 2;
        $userRelationshipType->save();

        $relationship = new MarxRelationship();
        $relationship->name = "Samy";
        $relationship->user_relationship_type_id = 1;
        $relationship->save();

        $currency = new MarxCurrencies();
        $currency->name = "Euro";
        $currency->label = "eur";
        $currency->save();

        $currency = new MarxCurrencies();
        $currency->name = "Pièce d'or";
        $currency->label = "po";
        $currency->save();

        $userCurrency = new MarxUserCurrencies();
        $userCurrency->user_id = 1;
        $userCurrency->currencies_id = 1;
        $userCurrency->save();



        $this->command->info('User table seeded!');
    }
}
