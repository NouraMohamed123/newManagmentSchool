<?php

use App\Models\Specialization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specializations')->delete();
        $specializations = [
            ['en'=> 'Arabic', 'ar'=> 'عربي'],
            ['en'=> 'Sciences', 'ar'=> 'علوم'],
            ['en'=> 'Computer', 'ar'=> 'حاسب الي'],
            ['en'=> 'math', 'ar'=> 'رياضه'],
            ['en'=> 'phyisics', 'ar'=> 'فيزياء'],


        ];
        foreach ($specializations as $S) {
            Specialization::create([
                'Name' => $S,
                'created_by'=>1
            ]);
        }
    }
}
