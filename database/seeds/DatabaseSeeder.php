<?php

use Illuminate\Database\Seeder;
use App\Models\MarxRelationship;
use App\Models\MarxUser;
use App\Models\MarxRelationshipType;
use App\Models\MarxRelationshipTypeTranslation;
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
        $user->auth0_id = 'auth0|5b8bcdb84b3e140de3010e77';
        $user->save();

        $relationshipType = new MarxRelationshipType();
        $relationshipType->code = 'Friend';
        $relationshipType->name = 'Friend';
        $relationshipType->save();

        $relationshipType = new MarxRelationshipType();
        $relationshipType->code = 'Colleague';
        $relationshipType->name = 'Colleague';
        $relationshipType->save();

        $relationshipType = new MarxRelationshipType();
        $relationshipType->code = 'Family';
        $relationshipType->name = 'Family';
        $relationshipType->save();

        $relationshipType = new MarxRelationshipType();
        $relationshipType->code = 'Other';
        $relationshipType->name = 'Other';
        $relationshipType->save();

        // english label
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Other';
        $relationshipTypeTranslation->lang = 'en';
        $relationshipTypeTranslation->name = 'Other';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Family';
        $relationshipTypeTranslation->lang = 'en';
        $relationshipTypeTranslation->name = 'Family';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Colleague';
        $relationshipTypeTranslation->lang = 'en';
        $relationshipTypeTranslation->name = 'Colleague';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Friend';
        $relationshipTypeTranslation->lang = 'en';
        $relationshipTypeTranslation->name = 'Friend';
        $relationshipTypeTranslation->save();

        // french label
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Other';
        $relationshipTypeTranslation->lang = 'fr';
        $relationshipTypeTranslation->name = 'Autre';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Family';
        $relationshipTypeTranslation->lang = 'fr';
        $relationshipTypeTranslation->name = 'Famille';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Colleague';
        $relationshipTypeTranslation->lang = 'fr';
        $relationshipTypeTranslation->name = 'Collègue';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Friend';
        $relationshipTypeTranslation->lang = 'fr';
        $relationshipTypeTranslation->name = 'Ami';
        $relationshipTypeTranslation->save();

        // nederlands - dutch label
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Other';
        $relationshipTypeTranslation->lang = 'nl';
        $relationshipTypeTranslation->name = 'Anders';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Family';
        $relationshipTypeTranslation->lang = 'nl';
        $relationshipTypeTranslation->name = 'Familie';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Colleague';
        $relationshipTypeTranslation->lang = 'nl';
        $relationshipTypeTranslation->name = 'Collega';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Friend';
        $relationshipTypeTranslation->lang = 'nl';
        $relationshipTypeTranslation->name = 'Vriend';
        $relationshipTypeTranslation->save();

        // deutsch - german label
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Other';
        $relationshipTypeTranslation->lang = 'de';
        $relationshipTypeTranslation->name = 'Anders';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Family';
        $relationshipTypeTranslation->lang = 'de';
        $relationshipTypeTranslation->name = 'Familie';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Colleague';
        $relationshipTypeTranslation->lang = 'de';
        $relationshipTypeTranslation->name = 'Kollege';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Friend';
        $relationshipTypeTranslation->lang = 'de';
        $relationshipTypeTranslation->name = 'Freund';
        $relationshipTypeTranslation->save();

        // norsk - norwegian label
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Other';
        $relationshipTypeTranslation->lang = 'no';
        $relationshipTypeTranslation->name = 'Annen';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Family';
        $relationshipTypeTranslation->lang = 'no';
        $relationshipTypeTranslation->name = 'Familie';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Colleague';
        $relationshipTypeTranslation->lang = 'no';
        $relationshipTypeTranslation->name = 'Kollega';
        $relationshipTypeTranslation->save();
        $relationshipTypeTranslation = new MarxRelationshipTypeTranslation();
        $relationshipTypeTranslation->code = 'Friend';
        $relationshipTypeTranslation->lang = 'no';
        $relationshipTypeTranslation->name = 'Venn';
        $relationshipTypeTranslation->save();

        $userRelationshipType = new MarxUserRelationshipType();
        $userRelationshipType->user_id = 1;
        $userRelationshipType->relationship_type_id = 1;
        $userRelationshipType->save();

        $userRelationshipType = new MarxUserRelationshipType();
        $userRelationshipType->user_id = 1;
        $userRelationshipType->relationship_type_id = 2;
        $userRelationshipType->reminder_date = 7;
        $userRelationshipType->save();

        $userRelationshipType = new MarxUserRelationshipType();
        $userRelationshipType->user_id = 1;
        $userRelationshipType->relationship_type_id = 3;
        $userRelationshipType->save();

        $userRelationshipType = new MarxUserRelationshipType();
        $userRelationshipType->user_id = 1;
        $userRelationshipType->relationship_type_id = 4;
        $userRelationshipType->save();


        // all this below is for testing

        $relationship = new MarxRelationship();
        $relationship->name = "Samy";
        $relationship->user_relationship_type_id = 1;
        $relationship->save();

        $payment = new MarxPayment();
        $payment->user_id = 1;
        $payment->relationship_id = 1;
        $payment->title = "Repas du midi";
        $payment->detail = "C'était vraiment bon";
        $payment->amount = 12.50;
        $payment->date = date('Y-m-d');
        $payment->type = 'deb';
        $payment->currency = 'Euro';
        $payment->save();

        $payment = new MarxPayment();
        $payment->user_id = 1;
        $payment->relationship_id = 1;
        $payment->title = "Livre";
        $payment->amount = 9;
        $payment->date = date('Y-m-d');
        $payment->type = 'cre';
        $payment->currency = 'Gold';
        $payment->save();

        $reminderDate = new MarxReminderDate();
        $reminderDate->payment_id = 1;
        $reminderDate->date = '2018-12-24';
        $reminderDate->save();

        $this->command->info('User table seeded!');
    }
}
