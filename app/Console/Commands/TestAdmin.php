<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TestAdmin extends Command
{
    protected $signature = 'test:admin';
    protected $description = 'Test the admin dashboard';

    public function handle()
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->error("No admin user found.");
            return;
        }
        
        Auth::login($admin);
        
        $this->info("--- ADMIN DASHBOARD ---");
        $controller = new \App\Http\Controllers\Admin\AdminController();
        try {
            $response = $controller->dashboard();
            $response->render();
            $this->info("Dashboard rendered successfully.");
        } catch (\Exception $e) {
            $this->error("Admin Dashboard Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
        }

        $this->info("\n--- ADMIN USERS ---");
        try {
            $response = $controller->users(new \Illuminate\Http\Request());
            $response->render();
            $this->info("Users rendered successfully.");
        } catch (\Exception $e) {
            $this->error("Admin Users Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
        }

        $this->info("\n--- ADMIN INCIDENTS ---");
        try {
            $response = $controller->incidents(new \Illuminate\Http\Request());
            $response->render();
            $this->info("Incidents rendered successfully.");
        } catch (\Exception $e) {
            $this->error("Admin Incidents Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
        }

        $this->info("\n--- ADMIN DONATIONS ---");
        try {
            $response = $controller->donations(new \Illuminate\Http\Request());
            $response->render();
            $this->info("Donations rendered successfully.");
        } catch (\Exception $e) {
            $this->error("Admin Donations Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
        }
    }
}
