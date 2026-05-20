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
        $categories = [
            ['name' => 'Proteína',    'slug' => 'proteina'],
            ['name' => 'Creatina',    'slug' => 'creatina'],
            ['name' => 'Pre-entreno', 'slug' => 'pre-entreno'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
