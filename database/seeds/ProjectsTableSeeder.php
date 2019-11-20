<?php

use Illuminate\Database\Seeder;

use App\Models\Project;
use App\Models\Account;

//$table->bigIncrements('id');
//$table->bigInteger('carrier_id');
//$table->bigInteger('oem_id');
//$table->bigInteger('odm_id');
//$table->string('model_name');
//$table->integer('connectivity');
//$table->string('type');
//$table->integer('financing');
//$table->timestamps();
class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);


        $oem = Account::where('name', 'OEM')->first();
        $odm = Account::where('name', 'ODM')->first();
        $carrier = Account::where('name', 'CARRIER')->first();

        $oems = Account::where('parent_id', $oem->id)->get();
        $odms = Account::where('parent_id', $odm->id)->get();
        $carriers = Account::where('parent_id', $carrier->id)->get();

        $connectivitys = ['3G', '4G', '5G'];
        $financings = ['yes', 'no'];

        for ($i = 0; $i < 100; $i++) {
            DB::table('projects')->insert([
                'oem_id' => $faker->randomElement($oems)->id,
                'odm_id' => $faker->randomElement($odms)->id,
                'carrier_id' => $faker->randomElement($carriers)->id,
                'type' => 'Type_' . $i,
                'financing' => $faker->randomElement($financings),
                'model_name' => 'Model_' . $i,
                'connectivity' => $faker->randomElement($connectivitys)
            ]);
        }

    }
}
