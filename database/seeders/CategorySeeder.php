<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Alimentação', 'Moradia', 'Saúde', 'Transporte', 'Educação', 'Lazer', 'Contas', 'Outros'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
