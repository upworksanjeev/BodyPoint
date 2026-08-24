<?php

namespace Database\Seeders;

use App\Support\Vault\VaultCatalogImporter;
use Illuminate\Database\Seeder;

class VaultAssetSeeder extends Seeder
{
    public function run(): void
    {
        $summary = app(VaultCatalogImporter::class)->import();

        $this->command?->info(sprintf(
            'Vault catalogue: %d created, %d updated (%d total).',
            $summary['created'],
            $summary['updated'],
            $summary['total']
        ));
    }
}
