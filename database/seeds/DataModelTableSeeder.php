<?php

use Illuminate\Database\Seeder;
use App\Models\DataModel;

class DataModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataModel::create(['vid' => 1, 'name' => 'TestModel', 'author_id' => 1]);
    }
}
