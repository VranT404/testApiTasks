<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Add the User model
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get all user IDs
        $userIds = User::pluck('id')->toArray();

        // If there are no users, create a user first
        if (empty($userIds)) {
            User::factory()->create();
            $userIds = User::pluck('id')->toArray();
        }

        // Define sample tasks data
        $tasksData = [
            [
                'user_id' => $userIds[array_rand($userIds)],
                'title' => 'Task 1',
                'description' => 'Description for Task 1',
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'title' => 'Task 2',
                'description' => 'Description for Task 2',
                'status' => 'completed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'title' => 'Task 3',
                'description' => 'Description for Task 3',
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Insert data into the tasks table
        DB::table('tasks')->insert($tasksData);
    }
}
