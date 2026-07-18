<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Incident;

class TestEndpoints extends Command
{
    protected $signature = 'test:endpoints';
    protected $description = 'Test the endpoints';

    public function handle()
    {
        $user = User::first();
        Auth::login($user);

        $this->info("--- INCIDENT ---");
        $controller = new \App\Http\Controllers\IncidentController();
        $request = \Illuminate\Http\Request::create('/incidents', 'POST', [
            'title' => 'Test Incident',
            'description' => 'This is a test incident description that must be at least 20 chars long.',
            'type' => 'flood',
            'severity' => 'high',
            'location_name' => 'Dhaka',
            'needs_volunteers' => '1',
            'needs_donations' => '1',
        ]);
        try {
            $response = $controller->store($request);
            if ($response instanceof \Illuminate\Http\RedirectResponse) {
                $this->info('Incident Redirect to: ' . $response->getTargetUrl());
                if (session()->has('success')) $this->info('Success message: ' . session('success'));
                if (session()->has('error')) $this->error('Error message: ' . session('error'));
            } else {
                $this->info('Incident response class: ' . get_class($response));
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Incident Validation Error: ' . json_encode($e->errors()));
        } catch (\Exception $e) {
            $this->error('Incident Error: ' . $e->getMessage());
        }

        $this->info("\n--- DONATION ---");
        $controller2 = new \App\Http\Controllers\DonationController();
        $request2 = \Illuminate\Http\Request::create('/donations', 'POST', [
            'title' => 'Test Donation',
            'description' => 'Donation description here',
            'category' => 'food',
            'quantity' => '10',
            'unit' => 'kg',
        ]);
        try {
            $response2 = $controller2->store($request2);
            if ($response2 instanceof \Illuminate\Http\RedirectResponse) {
                $this->info('Donation Redirect to: ' . $response2->getTargetUrl());
                if (session()->has('success')) $this->info('Success message: ' . session('success'));
                if (session()->has('error')) $this->error('Error message: ' . session('error'));
            } else {
                $this->info('Donation response class: ' . get_class($response2));
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Donation Validation Error: ' . json_encode($e->errors()));
        } catch (\Exception $e) {
            $this->error('Donation Error: ' . $e->getMessage());
        }

        $this->info("\n--- TASK ---");
        $incident = Incident::first();
        $controller3 = new \App\Http\Controllers\VolunteerController();
        $request3 = \Illuminate\Http\Request::create('/volunteer-tasks', 'POST', [
            'incident_id' => $incident->id ?? 1,
            'title' => 'Test Task',
            'description' => 'This is a test task description.',
            'category' => 'search_rescue',
            'priority' => 'high',
            'volunteers_needed' => 10,
        ]);
        try {
            $response3 = $controller3->storeTask($request3);
            if ($response3 instanceof \Illuminate\Http\RedirectResponse) {
                $this->info('Task Redirect to: ' . $response3->getTargetUrl());
                if (session()->has('success')) $this->info('Success message: ' . session('success'));
                if (session()->has('error')) $this->error('Error message: ' . session('error'));
            } else {
                $this->info('Task response class: ' . get_class($response3));
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Task Validation Error: ' . json_encode($e->errors()));
        } catch (\Exception $e) {
            $this->error('Task Error: ' . $e->getMessage());
        }
    }
}
