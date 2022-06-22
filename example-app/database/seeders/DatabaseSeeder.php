<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Country::create(['name'=>'India'],['name'=>'Saudi Arabia']);
        Country::create(['name'=>'Saudi Arabia']);
        State::create(['name'=>'Kerala','country_id'=>1]);
        State::create(['name'=>'Tamil Nadu','country_id'=>1]);
        State::create(['name'=>'Karnataka','country_id'=>1]);
        State::create(['name'=>'Riyadh','country_id'=>2]);
        State::create(['name'=>'Makkah','country_id'=>2]);
        State::create(['name'=>'Qassim Province','country_id'=>2]);
        //Student::create(['name'=>'Test 1','country_id'=>1,'state_id'=>1,'image'=>'photo']);
        //Student::create(['name'=>'Test 2','country_id'=>2,'state_id'=>5,'image'=>'photo']);
    }
}
