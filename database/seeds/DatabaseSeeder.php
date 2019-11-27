<?php

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
        $this->call(UsersSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(CriteriaTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);


        $this->call(DataModelTableSeeder::class);
        $this->call(ForecastItemTableSeeder::class);
    }
}
