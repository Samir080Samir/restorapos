<?php

namespace App\Console\Commands;

use App\Models\License;
use Illuminate\Console\Command;

class CheckExpiredLicenses extends Command
{
    protected $signature = 'licenses:check-expired';

    protected $description = 'Müddəti bitmiş lisenziyaları yoxlayır və restoranları deaktiv edir';

    public function handle(): int
    {
        $licenses = License::with('restaurant')
            ->where('status', 'active')
            ->where('auto_suspend', true)
            ->whereDate('end_date', '<', now())
            ->get();

        foreach ($licenses as $license) {
            $license->update([
                'status' => 'expired',
                'suspended_at' => now(),
                'suspend_reason' => 'Lisenziya müddəti bitdiyi üçün sistem avtomatik dayandırıldı.',
            ]);

            if ($license->restaurant) {
                $license->restaurant->update([
                    'status' => 'inactive',
                ]);
            }
        }

        $this->info($licenses->count() . ' lisenziya expired edildi.');

        return Command::SUCCESS;
    }
}
