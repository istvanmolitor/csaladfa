<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RelationshipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relationships = [
            ['name' => 'Parent', 'description' => 'Father or Mother'],
            ['name' => 'Child', 'description' => 'Son or Daughter'],
            ['name' => 'Sibling', 'description' => 'Brother or Sister'],
            ['name' => 'Spouse', 'description' => 'Husband or Wife'],
            ['name' => 'Grandparent', 'description' => 'Grandfather or Grandmother'],
            ['name' => 'Grandchild', 'description' => 'Grandson or Granddaughter'],
            ['name' => 'Aunt', 'description' => 'Paternal or maternal aunt'],
            ['name' => 'Uncle', 'description' => 'Paternal or maternal uncle'],
            ['name' => 'Niece', 'description' => 'Sister\'s or brother\'s daughter'],
            ['name' => 'Nephew', 'description' => 'Sister\'s or brother\'s son'],
            ['name' => 'Cousin', 'description' => 'Child of parent\'s sibling'],
            ['name' => 'In-law', 'description' => 'Spouse\'s family member'],
            ['name' => 'Step-sibling', 'description' => 'Sibling from remarriage'],
            ['name' => 'Step-parent', 'description' => 'Parent\'s spouse'],
        ];

        foreach ($relationships as $relationship) {
            DB::table('relationship_types')->insert([
                'name' => $relationship['name'],
                'slug' => Str::slug($relationship['name']),
                'description' => $relationship['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
