<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Users\Database\Seeders\UserStatusSeeder;
use Modules\Users\Database\Seeders\DepartmentSeeder;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(UserStatusSeeder::class);
        $this->call(DepartmentSeeder::class);
    }
}
