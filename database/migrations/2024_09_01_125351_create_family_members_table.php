<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('fam_lastname')->nullable();
            $table->string('fam_firstname')->nullable();
            $table->string('fam_middlename')->nullable();
            $table->string('fam_relationship')->nullable();
            $table->date('fam_birthday')->nullable();
            $table->integer('fam_age')->nullable();
            $table->string('fam_gender')->nullable();
            $table->string('fam_status')->nullable();
            $table->string('fam_education')->nullable();
            $table->string('fam_occupation')->nullable();
            $table->decimal('fam_income', 10, 2)->nullable();
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_members');
    }
}
