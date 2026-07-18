# Disaster & Emergency Relief Coordination Platform

A Laravel-based web application for coordinating disaster relief efforts — connecting victims who need help, volunteers who can provide it, donors contributing resources, and administrators overseeing the whole operation.

## Features

- **Role-based access** — Admin, Victim, and Volunteer roles with dedicated dashboards and permissions
- **Incident management** — report, track, and update the status of disaster incidents
- **Relief requests** — victims can submit requests for aid tied to specific incidents
- **Donations** — track and manage incoming donations toward relief efforts
- **Volunteer tasks** — assign and manage tasks for volunteers responding to incidents
- **Admin panel** — centralized dashboard for managing users, incidents, requests, donations, and tasks
- **Authentication** — powered by Laravel Breeze (registration, login, password reset, email verification)

## Tech Stack

- **Backend:** Laravel (PHP 8.2+)
- **Frontend:** Blade templates, Tailwind CSS, Vite
- **Auth:** Laravel Breeze
- **Database:** MySQL / SQLite (configurable)


## Default Roles

After seeding, the following roles are available in the system:

| Role      | Access                                                    |
|-----------|------------------------------------------------------------|
| Admin     | Full access to `/admin` — manage users, incidents, requests, donations, tasks |
| Victim    | Submit and track relief requests                           |
| Volunteer | View and manage assigned tasks                             |

## Project Structure
```plaintext
app/
├── Http/
│   ├── Controllers/       # Admin, Auth, and core resource controllers
│   ├── Middleware/        # Role-based middleware (Admin, Victim, Volunteer)
│   └── Requests/          # Form request validation
├── Models/                # Eloquent models (User, Incident, ReliefRequest, Donation, VolunteerTask)
└── View/Components/       # Blade layout components
resources/
├── views/                 # Blade templates (admin, auth, incidents, donations, requests, volunteers)
├── css/ & js/             # Frontend assets
routes/
├── web.php                # Application routes
└── auth.php               # Breeze authentication routes
database/
├── migrations/            # Database schema
└── seeders/               # Sample data seeding
```
