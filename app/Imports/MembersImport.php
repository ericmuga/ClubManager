<?php

namespace App\Imports;

use App\Models\User as Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Faker\Factory as Faker;

class MembersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $faker = Faker::create();
        return new Member([
            'name' => $row['name'],
            'user_type' => 'member',
            'email' => $row['email'],
            'nationality' => $row['nationality'],
            'gender' => $row['gender'],
            'member_no' => $row['member_no'],
            'phone' => $row['phone'],
            'password'=>bcrypt('qwert123.'),
             'avatar'=>$faker->imageUrl(640, 480, 'people'),
        ]);
    }
}
