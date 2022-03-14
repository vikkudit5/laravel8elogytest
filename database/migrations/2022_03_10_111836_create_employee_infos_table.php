<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_infos', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('email')->unique();
            $table->enum('gender',['male','female']);
            $table->string('contact_number');
            $table->string('address');
            $table->date('joining_date');
            $table->date('dob');
            $table->integer('department_id')->length(11);
            $table->integer('education_id')->length(11);
            $table->string('experience');
            $table->string('hobbies_id')->length(11);
            $table->string('photo');
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
        Schema::dropIfExists('employee_infos');
    }
};
