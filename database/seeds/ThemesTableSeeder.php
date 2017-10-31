<?php

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themes = [
            [
                'name' => 'Default',
                'link' => 'null',
            ],
        ];

        foreach ($themes as $theme) {
            $newTheme = Theme::where('name', '=', $theme['name'])->first();
            if ($newTheme === null) {
                $newTheme = Theme::create([
                    'name'          => $theme['name'],
                    'link'          => $theme['link'],
                    'taggable_id'   => 0,
                    'taggable_type' => 'theme',
                ]);
            }
        }

        $allThemes = Theme::All();
        foreach ($allThemes as $theme) {
            $theme->taggable_id = $theme->id;
            $theme->save();
        }
    }
}
