<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('middle')->nullable()->change();
            $table->string('suffix')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('age')->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->string('pob')->nullable()->change();
            $table->string('sex')->nullable()->change();
            $table->string('educational_attainment')->nullable()->change();
            $table->string('civil_status')->nullable()->change();
            $table->string('religion')->nullable()->change();
            $table->string('nationality')->nullable()->change();
            $table->string('occupation')->nullable()->change();
            $table->string('monthly_income')->nullable()->change();
            $table->string('contact_number')->nullable()->change();
            $table->string('source_of_referral')->nullable()->change();
            $table->longText('circumstances_of_referral')->nullable()->change();
            $table->longText('family_background')->nullable()->change();
            $table->longText('health_history')->nullable()->change();
            $table->longText('economic_situation')->nullable()->change();
            $table->string('house_structure')->nullable()->change();
            $table->string('floor')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->string('number_of_rooms')->nullable()->change();
            $table->string('appliances')->nullable()->change();
            $table->string('other_appliances')->nullable()->change();
            $table->string('monthly_expenses')->nullable()->change();
            $table->string('indicate')->nullable()->change();
            $table->string('assessment')->nullable()->change();
            $table->string('recommendation')->nullable()->change();
            $table->string('tracking')->nullable()->change();
            $table->string('problem_identification')->nullable()->change();
            $table->string('data_gather')->nullable()->change();
            $table->string('eval')->nullable()->change();
            $table->string('control_number')->nullable()->change();
            $table->longText('problem_presented')->nullable()->change();
            $table->longText('services')->nullable()->change();
            $table->string('requirements')->nullable()->change();
            $table->string('home_visit')->nullable()->change();
            $table->string('interviewee')->nullable()->change();
            $table->string('interviewed_by')->nullable()->change();
            $table->longText('layunin')->nullable()->change();
            $table->longText('resulta')->nullable()->change();
            $table->longText('initial_findings')->nullable()->change();
            $table->longText('initial_agreement')->nullable()->change();
            $table->longText('assessment1')->nullable()->change();
            $table->longText('case_management_evaluation')->nullable()->change();
            $table->longText('case_resolution')->nullable()->change();
            $table->string('reviewing')->nullable()->change();
            $table->string('approving')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('first_name')->change();
            $table->string('last_name')->change();
            $table->string('middle')->change();
            $table->string('suffix')->change();
            $table->string('address')->change();
            $table->string('age')->change();
            $table->date('date_of_birth')->change();
            $table->string('pob')->change();
            $table->string('sex')->change();
            $table->string('educational_attainment')->change();
            $table->string('civil_status')->change();
            $table->string('religion')->change();
            $table->string('nationality')->change();
            $table->string('occupation')->change();
            $table->string('monthly_income')->change();
            $table->string('contact_number')->change();
            $table->string('source_of_referral')->change();
            $table->longText('circumstances_of_referral')->change();
            $table->longText('family_background')->change();
            $table->longText('health_history')->change();
            $table->longText('economic_situation')->change();
            $table->string('house_structure')->change();
            $table->string('floor')->change();
            $table->string('type')->change();
            $table->string('number_of_rooms')->change();
            $table->string('appliances')->change();
            $table->string('other_appliances')->change();
            $table->string('monthly_expenses')->change();
            $table->string('indicate')->change();
            $table->string('assessment')->change();
            $table->string('recommendation')->change();
            $table->string('tracking')->change();
            $table->string('problem_identification')->change();
            $table->string('data_gather')->change();
            $table->string('eval')->change();
            $table->string('control_number')->change();
            $table->longText('problem_presented')->change();
            $table->longText('services')->change();
            $table->string('requirements')->change();
            $table->string('home_visit')->change();
            $table->string('interviewee')->change();
            $table->string('interviewed_by')->change();
            $table->longText('layunin')->change();
            $table->longText('resulta')->change();
            $table->longText('initial_findings')->change();
            $table->longText('initial_agreement')->change();
            $table->longText('assessment1')->change();
            $table->longText('case_management_evaluation')->change();
            $table->longText('case_resolution')->change();
            $table->string('reviewing')->change();
            $table->string('approving')->change();
        });
    }
}
