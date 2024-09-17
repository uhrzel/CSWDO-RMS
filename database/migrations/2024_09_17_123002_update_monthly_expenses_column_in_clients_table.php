<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMonthlyExpensesColumnInClientsTable extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            // Add the schema change here
            $table->longText('monthly_expenses')->change();
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            // Revert the schema change here if needed
            $table->text('monthly_expenses')->change();
        });
    }
}
