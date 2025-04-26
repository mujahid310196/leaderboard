<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;       // ✅ Import User model
use App\Models\Activity;   // ✅ Import Activity model

class ActivitySeeder extends Seeder
{

    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            
            $count = rand(10, 30);

            for ($i = 0; $i < $count; $i++) {
                Activity::create([
                    'user_id' => $user->id,
                    'performed_at' => now()->subDays(rand(0, 30)),
                    'points' => 20,
                ]);
            }
        }
    }
}
