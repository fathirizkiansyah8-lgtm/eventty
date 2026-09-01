<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'School Event',
                'description' => 'Acara sekolah umum seperti upacara, rapat, dll',
                'color' => '#3b82f6',
                'icon' => 'fas fa-school',
            ],
            [
                'name' => 'Workshop',
                'description' => 'Workshop dan pelatihan untuk siswa',
                'color' => '#10b981',
                'icon' => 'fas fa-tools',
            ],
            [
                'name' => 'Competition',
                'description' => 'Kompetisi dan lomba antar siswa',
                'color' => '#f59e0b',
                'icon' => 'fas fa-trophy',
            ],
            [
                'name' => 'Seminar',
                'description' => 'Seminar edukatif dan pengembangan diri',
                'color' => '#8b5cf6',
                'icon' => 'fas fa-chalkboard-teacher',
            ],
            [
                'name' => 'Training',
                'description' => 'Pelatihan khusus dan pengembangan skill',
                'color' => '#ef4444',
                'icon' => 'fas fa-dumbbell',
            ],
            [
                'name' => 'Meeting',
                'description' => 'Rapat OSIS dan organisasi siswa',
                'color' => '#06b6d4',
                'icon' => 'fas fa-users',
            ],
        ];

        foreach ($categories as $category) {
            EventCategory::create($category);
        }
    }
}
