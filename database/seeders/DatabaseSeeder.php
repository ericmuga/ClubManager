<?php

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Meeting::factory(10)->create();


        User::factory()->count(50)->create();
        $user=User::first();
        $user->email='eric.muga@gmail.com';
        $user->name='Eric Muga';
        $user->user_type='member';
        $user->phone='0720816931';
        $user->password=bcrypt('Tester123');
        $user->save();

        $user=User::orderBy('id','desc')->first();
        $user->email='fkinuthia@farmerschoice.co.ke';
        $user->name='Flora Kinuthia';
        $user->user_type='member';
        $user->phone='0706561813';
        $user->password=bcrypt('rotary2024$');
        $user->save();
    }
}
