<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            'Programming',
            'UI/UX Design',
            'Digital Marketing',
        ];

        foreach ($array as $item) {
            Category::create([
                'name' => $item,
            ]);
        }
    }
}
