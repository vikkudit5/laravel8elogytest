<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Models\Employee_info;

class Employee_infoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $employee =     new Employee_info();

        $employee->employee_name = $faker->name;
        $employee->email = $faker->email;
        $employee->gender = "male";
        $employee->contact_number = "9717519768";
        $employee->address = $faker->address;
        $employee->joining_date = $faker->date;
        $employee->experience = "4";
        $employee->department_id = "1";
        $employee->education_id = "1";
        $employee->hobbies_id = "1";
        $employee->dob = $faker->date;
        $employee->photo = "tes.jpg";

        $employee->save();

    }
}
