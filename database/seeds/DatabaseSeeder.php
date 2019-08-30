<?php

use Illuminate\Database\Seeder;
use App\Models\MarxRelationship;
use App\Models\MarxUser;
use App\Models\MarxRelationshipType;
use App\Models\MarxUserRelationshipType;
use App\Models\MarxCurrencies;
use App\Models\MarxUserCurrencies;
use App\Models\MarxPayment;
use App\Models\MarxReminderDate;

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
        $user->auth0Id = 'auth0|5b8bcdb84b3e140de3010e77';
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
        $userRelationshipType->userId = 1;
        $userRelationshipType->relationshipTypeId = 2;
        $userRelationshipType->save();

        $relationship = new MarxRelationship();
        $relationship->name = "Samy";
        $relationship->user_relationshipTypeId = 1;
        $relationship->save();

        $payment = new MarxPayment();
        $payment->userId = 1;
        $payment->relationshipId = 1;
        $payment->title = "Repas du midi";
        $payment->detail = "C'était vraiment bon";
        $payment->amount = 12.50;
        $payment->date = date('Y-m-d');
        $payment->type = 'deb';
        $payment->save();

        $payment = new MarxPayment();
        $payment->userId = 1;
        $payment->relationshipId = 1;
        $payment->title = "Livre";
        $payment->amount = 9;
        $payment->date = date('Y-m-d');
        $payment->type = 'cre';
        $payment->save();

        $reminderDate = new MarxReminderDate();
        $reminderDate->paymentId = 1;
        $reminderDate->date = '2018-12-24';
        $reminderDate->save();

        $this->command->info('User table seeded!');
    }
}
