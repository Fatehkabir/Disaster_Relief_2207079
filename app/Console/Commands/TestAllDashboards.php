<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TestAllDashboards extends Command
{
    protected $signature = 'test:dashboards';
    protected $description = 'Test all dashboard rendering';

    public function handle()
    {
        $roles = ['admin', 'victim', 'volunteer', 'donor', 'organization'];
        $controller = new \App\Http\Controllers\DashboardController();

        foreach ($roles as $role) {
            $user = User::where('role', $role)->first();
            if (!$user) {
                $this->warn("No $role user found.");
                continue;
            }

            Auth::login($user);
            $this->info("--- $role DASHBOARD ---");
            try {
                $response = $controller->index();
                $response->render();
                $this->info("$role dashboard rendered successfully.");
            } catch (\Exception $e) {
                $this->error("$role Dashboard Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            }
        }
    }
}
