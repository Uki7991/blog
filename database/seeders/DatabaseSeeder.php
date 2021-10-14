<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        foreach (Article::$themes as $theme) {
            \DB::table('themes')->insert([
                'title' => $theme,
            ]);
        }
    }
}
