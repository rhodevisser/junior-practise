<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

class CleanLogs extends Command
{
    protected $signature = 'logs:clean {--days=30  : Delete logs older than 30 days} {--force : Skip confirmation}';
    protected $description = 'Delete logs older than 30 days';
    /**
     * Execute the console command.
     */
    public function handle()

    {
        $count = ActivityLog::where('created_at', '<', now()->subDays($this->option('days')))->count();

        if ($count === 0) {
            $this->info('No logs to clean.');
            return Command::SUCCESS;
        }

        if (!$this->option('force')) {
            if (!$this->confirm("Delete {$count} log record(s)?")) {
                return Command::SUCCESS;
            }
        }

        $count = ActivityLog::where('created_at', '<', now()->subDays($this->option('days')))->delete();
        $this->info("Deleted {$count} log record(s).");
        return Command::SUCCESS;
        }
    }




