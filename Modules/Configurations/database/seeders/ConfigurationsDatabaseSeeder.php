<?php

namespace Modules\Configurations\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Configurations\Database\Seeders\ContentMappingSeeder;
use Modules\Configurations\Database\Seeders\ParmeterConfigSeeder;

class ConfigurationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(ContentMappingSeeder::class);
        $this->call(ParmeterConfigSeeder::class);
    }
}
