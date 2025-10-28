<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateUserWithPaypal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //Rename users.paypal_subscribtion_id to users.paypal_subscriber_id - so we can keep old data
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('paypal_subscribtion_id', 'paypal_subscriber_id');
            });
        } catch (\Exception $e) {
            
        }
        
       //Add users.subscription_plan_id
       try {
            Schema::table('users', function (Blueprint $table) {
                $table->string('subscription_plan_id')->nullable();
            });
        } catch (\Exception $e) {
            
        }
       

     

     
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('');
    }
}
