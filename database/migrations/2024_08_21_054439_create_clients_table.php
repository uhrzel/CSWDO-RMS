<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('middle')->nullable();
            $table->string('suffix')->nullable();
            $table->string('address')->nullable();
            $table->string('age')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('pob')->nullable();
            $table->string('sex')->nullable();
            $table->string('educational_attainment')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();
            $table->string('occupation')->nullable();
            $table->string('monthly_income')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('source_of_referral')->nullable();
            $table->text('circumstances_of_referral')->nullable();
            $table->text('family_background')->nullable();
            $table->text('health_history')->nullable();
            $table->text('economic_situation')->nullable();
            $table->string('house_structure')->nullable();
            $table->string('floor')->nullable();
            $table->string('type')->nullable();
            $table->string('number_of_rooms')->nullable();
            $table->string('appliances')->nullable();
            $table->string('other_appliances')->nullable();
            $table->string('monthly_expenses')->nullable();
            $table->string('indicate')->nullable();
            $table->string('assessment')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('tracking')->nullable();
            $table->string('problem_identification')->nullable();
            $table->string('data_gather')->nullable();
            $table->string('eval')->nullable();
            $table->string('control_number')->nullable();
            $table->text('problem_presented')->nullable();
            $table->text('services')->nullable();
            $table->text('requirements')->nullable();
            $table->string('home_visit')->nullable();
            $table->string('interviewee')->nullable();
            $table->string('interviewed_by')->nullable();
            $table->text('layunin')->nullable();
            $table->text('resulta')->nullable();
            $table->text('initial_findings')->nullable();
            $table->text('initial_agreement')->nullable();
            $table->text('assessment1')->nullable();
            $table->text('case_management_evaluation')->nullable();
            $table->text('case_resolution')->nullable();
            $table->string('reviewing')->nullable();
            $table->string('approving')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
