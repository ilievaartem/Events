<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Constants\DB\UserDBConstants;
use App\Constants\Role\UserRoleConstants;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            UserDBConstants::ID => Uuid::uuid7()->toString(),
            UserDBConstants::NAME => 'myTestUser',
            UserDBConstants::EMAIL => 'user@email.com',
            UserDBConstants::ROLE => UserRoleConstants::ROLE_USER,
            UserDBConstants::TELEPHONE => fake()->phoneNumber(),
            UserDBConstants::AVATAR => null,
            UserDBConstants::PASSWORD => 12345678,

        ]);

        User::create([
            UserDBConstants::ID => Uuid::uuid7()->toString(),
            UserDBConstants::NAME => 'myTestAdmin',
            UserDBConstants::EMAIL => 'admin@email.com',
            UserDBConstants::ROLE => UserRoleConstants::ROLE_ADMIN,
            UserDBConstants::TELEPHONE => fake()->phoneNumber(),
            UserDBConstants::AVATAR => null,
            UserDBConstants::PASSWORD => 12345678,

        ]);


        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $hashedPassword = Hash::make(fake()->password(6, 20));

            $users[] = [
                UserDBConstants::ID => Uuid::uuid7()->toString(),
                UserDBConstants::NAME => fake()->name(),
                UserDBConstants::EMAIL => fake()->freeEmail(),
                UserDBConstants::ROLE => fake()->randomElement([UserRoleConstants::ROLE_ADMIN, UserRoleConstants::ROLE_USER]),
                UserDBConstants::TELEPHONE => fake()->phoneNumber(),
                UserDBConstants::AVATAR => null,
                UserDBConstants::PASSWORD => $hashedPassword,

            ];
        }
        User::insert($users);
    }
}
