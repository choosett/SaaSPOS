<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateInactiveUsers extends Command
{
    protected $signature = 'update:inactive-users'; // ✅ Command Name

    protected $description = 'Set users inactive after 5 minutes of inactivity';

    public function handle()
    {
        $inactiveTime = now()->subMinutes(5); // ✅ Users inactive after 5 min
        
        $usersUpdated = User::where('last_activity', '<', $inactiveTime)
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        Log::info("🔄 Inactive Users Updated: {$usersUpdated}");

        $this->info("Users marked inactive: {$usersUpdated}");
    }
}
