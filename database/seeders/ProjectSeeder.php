<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected function fakeContributors(Faker $faker){

        $contributors_number = rand(0, 5);
        if($contributors_number === 0){
            $contributors_list = null;
        }else{

            $contributors = [];
    
            for ($i=0; $i < $contributors_number ; $i++) { 
                # code...
                $contributors [] = $faker->name();
            }
    
            $contributors_list = implode(', ', $contributors);
    
        }
        
        return [$contributors_number, $contributors_list];

    }



    public function run(Faker $faker): void
    {
        
        $types = Type::all(); // Collection di oggetti Type

        /** Tramite un metodo presente dentro la Collection */
        $types_ids = $types->pluck('id')->all(); // Array di types_ids 
        $technology_ids = Technology::all()->pluck('id')->all(); // Array con gli id delle technology

        
        
        // Creazione di dati temporanei tramite Faker
        for ($i=0; $i < 10 ; $i++) { 

            list($contributors_number, $contributors_list) = $this->fakeContributors($faker);
           


            # code...
            $project = new Project();


            $project->name = $faker->sentence(3);
            $project->slug = Str::slug($project->name);
            $project->link = $faker->url();
            $project->description = $faker->optional()->text(500);;
            $project->date_of_creation = $faker->dateTimeBetween('-1 year', 'now');
            $project->is_public = $faker->randomElement([true, false]);
            $project->contributors = $contributors_number;
            $project->contributors_name = $contributors_list;
            $project->type_id = $faker->optional()->randomElement($types_ids);


            // Ricorda che fino a QUI l'id del Project NON ESISTE
            $project->save();            

            // QUI il Project è stato salvato ed HA un id
            if(rand(1, 100) > 75){
                $project->delete();
            }


            // prendendo un numero random (grazie a null), di id random appartenenti ai technologies
            $random_technologiy_ids = $faker->randomElements($technology_ids, null);

            // assegno un numero casuale di technologies al mio project
            $project->technologies()->attach($random_technologiy_ids);
        }
    }
}
