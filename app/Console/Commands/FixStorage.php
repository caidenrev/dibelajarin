<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:fix {--clear : Clear all cache after fixing storage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix storage directory structure and permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing storage directories...');

        // List of required storage directories
        $directories = [
            storage_path('framework/cache'),
            storage_path('framework/cache/data'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('framework/testing'),
            storage_path('app/public'),
            storage_path('app/private'),
            storage_path('app/livewire-tmp'),
            storage_path('logs'),
            base_path('bootstrap/cache'),
        ];

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
                $this->info("Created: {$directory}");
            } else {
                $this->comment("Already exists: {$directory}");
            }
        }

        // Set permissions for existing directories
        try {
            if (PHP_OS_FAMILY !== 'Windows') {
                $this->info('Setting permissions...');
                chmod(storage_path(), 0775);
                chmod(base_path('bootstrap/cache'), 0775);
                $this->info('Permissions set successfully.');
            } else {
                $this->comment('Skipping permission changes on Windows.');
            }
        } catch (\Exception $e) {
            $this->warn('Could not set permissions: ' . $e->getMessage());
        }

        $this->newLine();
        $this->info('Storage directories fixed successfully!');

        // Clear caches if requested
        if ($this->option('clear')) {
            $this->newLine();
            $this->info('Clearing caches...');
            
            $this->call('cache:clear');
            $this->call('config:clear');
            $this->call('view:clear');
            $this->call('route:clear');
            
            $this->info('All caches cleared!');
        }

        return Command::SUCCESS;
    }
}
