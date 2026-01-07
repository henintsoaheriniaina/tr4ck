<?php

namespace Database\Seeders;

use App\Models\WalletStatus;
use Illuminate\Database\Seeder;

class WalletStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'label' => 'Actif',
                'value' => 'active',
            ],
            [
                'label' => 'Inactif',
                'value' => 'inactive',
            ],
            [
                'label' => 'Archivé',
                'value' => 'archived',
            ],
        ];

        foreach ($statuses as $status) {
            WalletStatus::updateOrCreate(
                ['value' => $status['value']],
                ['label' => $status['label']]
            );
        }
    }
}
