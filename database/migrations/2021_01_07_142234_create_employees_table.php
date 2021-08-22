<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_code')->unique();
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->dateTime('date_of_joining')->nullable();
            $table->string('profile')->nullable();
            $table->string('qualification')->nullable();
            $table->integer('department_code')->nullable();
            $table->decimal('ctc',15,2)->nullable();
            $table->decimal('in_hand_salary',15,2)->nullable();
            $table->json('phone_no')->nullable();
            $table->json('address');
            $table->enum('status', array('contract', 'permanent'));
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
