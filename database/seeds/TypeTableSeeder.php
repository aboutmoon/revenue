<?php

use Illuminate\Database\Seeder;
use App\Models\Type;
use App\Imports\TypeImport;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create(['name' => 'mPOS']);
        Type::create(['name' => 'SFP']);
        Type::create(['name' => 'Touch']);
    }
}
