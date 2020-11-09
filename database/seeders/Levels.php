<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;
class Levels extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Level::truncate();
        Level::insert([
            ['level'=>'Junior'],
            ['level'=>'Middle'],
            ['level'=>'Senior'],
        ]);
    }
}
