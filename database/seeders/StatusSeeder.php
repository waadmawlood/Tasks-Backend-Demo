<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create `To Do` default statuses
        \App\Models\Status::query()->firstOrCreate(
            [
                'name' => 'To Do',
                'color' => '#ffa500',
                'position' => 1,
                'workspace_id' => null,
                'user_id' => null,
            ],
            [
                'is_test' => false,
                'is_done' => false,
            ]
        );

        // Create `In Progress` default statuses
        \App\Models\Status::query()->firstOrCreate(
            [
                'name' => 'In Progress',
                'color' => '#1090E0',
                'position' => 2,
                'workspace_id' => null,
                'user_id' => null,
            ],
            [
                'is_test' => false,
                'is_done' => false,
            ]
        );

        // Create `Testing` default statuses
        \App\Models\Status::query()->firstOrCreate(
            [
                'name' => 'Testing',
                'color' => '#4d4dff',
                'position' => 3,
                'workspace_id' => null,
                'user_id' => null,
            ],
            [
                'is_test' => true,
                'is_done' => false,
            ]
        );

        // Create `Done Testing` default statuses
        \App\Models\Status::query()->firstOrCreate(
            [
                'name' => 'Done Production',
                'color' => '#27AE60',
                'position' => 4,
                'workspace_id' => null,
                'user_id' => null,
            ],
            [
                'is_test' => false,
                'is_done' => true,
            ]
        );
    }
}
