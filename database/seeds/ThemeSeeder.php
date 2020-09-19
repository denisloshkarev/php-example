<?php

use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\App\Models\Subject::class, 5)->create()->each(function ($subject) {

            factory(\App\Models\Section::class, 5)->create([
                'subject_id' => $subject->id
            ])->each(function ($section) {
                factory(\App\Models\Themes\Theme::class, 5)->create([
                    'section_id' => $section->id
                ]);
            });

        });

    }
}
