<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PruneUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus pengguna yang belum terverifikasi lebih dari satu jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mencari pengguna yang belum terverifikasi...');

        // Cari pengguna yang email_verified_at masih NULL
        // DAN dibuat lebih dari atau sama dengan 1 jam yang lalu
        $deletedCount = User::whereNull('email_verified_at')
                            ->where('created_at', '<=', now()->subHour())
                            ->delete();

        if ($deletedCount > 0) {
            $this->info("Berhasil menghapus {$deletedCount} pengguna.");
        } else {
            $this->info('Tidak ada pengguna yang perlu dihapus.');
        }

        return 0;
    }
}
