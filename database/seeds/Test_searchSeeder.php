<?php

use Illuminate\Database\Seeder;

class Test_searchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Test_search::class, 10)->create();

    }
}
