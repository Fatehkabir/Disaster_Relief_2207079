<?php

namespace App\Providers;

use App\Models\Donation;
use App\Models\Incident;
use App\Models\ReliefRequest;
use App\Models\Resource;
use App\Policies\DonationPolicy;
use App\Policies\IncidentPolicy;
use App\Policies\ReliefRequestPolicy;
use App\Policies\ResourcePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::policy(Incident::class,      IncidentPolicy::class);
        Gate::policy(ReliefRequest::class, ReliefRequestPolicy::class);
        Gate::policy(Donation::class,      DonationPolicy::class);
        Gate::policy(Resource::class,      ResourcePolicy::class);
    }
}
