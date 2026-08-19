<?php

namespace App\Console\Commands;

use App\Services\CnicMobileLinkService;
use Illuminate\Console\Command;

class SyncCnicMobileLinks extends Command
{
    protected $signature = 'cnic-mobile:sync';

    protected $description = 'Sync existing user/basic/policy CNIC-mobile pairs into cnic_mobile_links';

    public function handle(CnicMobileLinkService $service): int
    {
        $this->info('Syncing CNIC ↔ mobile relationships...');

        $stats = $service->syncExistingData();

        $this->table(
            ['Created', 'Skipped (already linked / incomplete)', 'Conflicts (logged)'],
            [[$stats['created'], $stats['skipped'], $stats['conflicts']]]
        );

        $this->info('Done.');

        return self::SUCCESS;
    }
}
