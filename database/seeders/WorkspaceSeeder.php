<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkspaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Workspace::factory(10)
        ->hasAttached(User::inRandomOrder()->limit(3)->get(), [], 'users')
        ->create();
    }
}
