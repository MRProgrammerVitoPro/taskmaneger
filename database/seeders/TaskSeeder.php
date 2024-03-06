<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create([
            'title' => 'Задача 1',
            'description' => 'Описание задачи 1',
            'status' => false,
        ]);

        Task::create([
            'title' => 'Задача 2',
            'description' => 'Описание задачи 2',
            'status' => true,
        ]);
    }
}
