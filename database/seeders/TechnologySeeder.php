<?php

namespace Database\Seeders;

use App\Http\Traits\Sluggable;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = ['html','css', 'bootstrap', 'js', 'vue', 'sql', 'php', 'laravel'];

        // FUNZIONA SOLO SE IL TAG SEEDER SI TROVA DOPO IL POST SEEDER (nel DatabaseSeeder)
        // $posts_id_coll = Post::all()->pluck('id'); // collection di id dei post




        foreach ($technologies as $technology_name) {
            $new_technology = new Technology();

            $new_technology->name = $technology_name;
            $new_technology->slug = Str::slug($new_technology->name);

            $new_technology->save();


            // FUNZIONA SOLO SE IL TAG SEEDER SI TROVA DOPO IL POST SEEDER (nel DatabaseSeeder)
            // $new_technology->posts()->attach($posts_id_coll->random(10)->all());
        }

    }
}
