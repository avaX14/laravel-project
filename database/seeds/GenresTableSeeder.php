<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Genre;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Genre::class, 5)->create();
    }
}
