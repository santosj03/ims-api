<?php

namespace Modules\Configurations\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Configurations\Models\ParameterConfig;

class ParmeterConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configData = $this->data();
        foreach ($configData as $data) {
            ParameterConfig::updateOrCreate(
                [
                    'code' => $data['code']
                ],
                [
                    "category" => $data['category'],
                    "code" => $data['code'],
                    "description" => $data['description'],
                    "data_type" => $data['data_type'],
                    "value" => $data['value']
                ]
            );
        }
    }

    private function data() {
        return [
            [
                "category" => "security", 
                "code" => "sec_session_timeout", 
                "description" => "User session timeframe", 
                "data_type" => "INT", 
                "value" => "60"
            ],
            [
                "category" => "security", 
                "code" => "sec_account_inactivity_days", 
                "description" => "User inactivity days", 
                "data_type" => "INT", 
                "value" => "30"
            ],
        ];
    }
}
