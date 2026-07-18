<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Incident;
use App\Models\ReliefRequest;
use App\Models\User;
use App\Models\VolunteerTask;
use App\Models\VolunteerTaskAssignment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        $admin = User::create([
            'name'      => 'Admin User',
            'email'     => 'admin@relief.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
            'phone'     => '01700000001',
            'is_active' => true,
        ]);

        $victim1 = User::create([
            'name'      => 'Rahim Uddin',
            'email'     => 'victim@relief.com',
            'password'  => Hash::make('password'),
            'role'      => 'victim',
            'phone'     => '01700000002',
            'is_active' => true,
        ]);

        $victim2 = User::create([
            'name'      => 'Salma Begum',
            'email'     => 'victim2@relief.com',
            'password'  => Hash::make('password'),
            'role'      => 'victim',
            'phone'     => '01700000003',
            'is_active' => true,
        ]);

        $volunteer1 = User::create([
            'name'      => 'Karim Hassan',
            'email'     => 'volunteer@relief.com',
            'password'  => Hash::make('password'),
            'role'      => 'volunteer',
            'phone'     => '01700000004',
            'is_active' => true,
        ]);

        $volunteer2 = User::create([
            'name'      => 'Nadia Islam',
            'email'     => 'volunteer2@relief.com',
            'password'  => Hash::make('password'),
            'role'      => 'volunteer',
            'phone'     => '01700000005',
            'is_active' => true,
        ]);

        
        $incident1 = Incident::create([
            'reported_by'     => $victim1->id,
            'title'           => 'Major Flood in Sylhet District',
            'description'     => 'Severe flooding has inundated low-lying areas of Sylhet. Thousands of families are displaced and urgently need food, clean water, and shelter.',
            'type'            => 'flood',
            'severity'        => 'critical',
            'status'          => 'active',
            'location_name'   => 'Sylhet, Bangladesh',
            'affected_people' => 5000,
            'needs_volunteers' => true,
            'needs_donations'  => true,
        ]);

        $incident2 = Incident::create([
            'reported_by'     => $victim2->id,
            'title'           => 'Cyclone Damage in Cox\'s Bazar',
            'description'     => 'A powerful cyclone has caused extensive damage to coastal areas. Homes are destroyed and residents need immediate assistance.',
            'type'            => 'cyclone',
            'severity'        => 'high',
            'status'          => 'verified',
            'location_name'   => 'Cox\'s Bazar, Bangladesh',
            'affected_people' => 2000,
            'needs_volunteers' => true,
            'needs_donations'  => true,
        ]);

        $incident3 = Incident::create([
            'reported_by'     => $victim1->id,
            'title'           => 'Fire in Dhaka Slum Area',
            'description'     => 'A devastating fire broke out in a slum area of Dhaka, leaving hundreds of families homeless.',
            'type'            => 'fire',
            'severity'        => 'medium',
            'status'          => 'pending',
            'location_name'   => 'Mirpur, Dhaka',
            'affected_people' => 800,
            'needs_volunteers' => false,
            'needs_donations'  => true,
        ]);

        
        ReliefRequest::create([
            'user_id'       => $victim1->id,
            'incident_id'   => $incident1->id,
            'title'         => 'Urgent Food and Water Needed',
            'description'   => 'Our family of 6 has been stranded for 3 days. We have no food or clean water left.',
            'type'          => 'food',
            'urgency'       => 'critical',
            'status'        => 'acknowledged',
            'people_count'  => 6,
            'location_name' => 'Sylhet Sadar, Sylhet',
            'contact_phone' => '01700000002',
        ]);

        ReliefRequest::create([
            'user_id'       => $victim2->id,
            'incident_id'   => $incident2->id,
            'title'         => 'Need Shelter After Cyclone',
            'description'   => 'Our house was completely destroyed by the cyclone. We need emergency shelter for 4 people.',
            'type'          => 'shelter',
            'urgency'       => 'high',
            'status'        => 'pending',
            'people_count'  => 4,
            'location_name' => 'Cox\'s Bazar Sadar',
            'contact_phone' => '01700000003',
        ]);

        ReliefRequest::create([
            'user_id'       => $victim1->id,
            'incident_id'   => null,
            'title'         => 'Medicine for Elderly',
            'description'   => 'My elderly parents need blood pressure and diabetes medicine urgently.',
            'type'          => 'medicine',
            'urgency'       => 'high',
            'status'        => 'pending',
            'people_count'  => 2,
            'location_name' => 'Mirpur, Dhaka',
            'contact_phone' => '01700000002',
        ]);

        
        Donation::create([
            'donor_id'        => $victim1->id,
            'incident_id'     => $incident1->id,
            'title'           => 'Rice and Lentils (50kg)',
            'description'     => 'Donating 50kg of rice and lentils for flood victims in Sylhet.',
            'category'        => 'food',
            'quantity'        => 50,
            'unit'            => 'kg',
            'status'          => 'collected',
            'pickup_location' => 'Dhanmondi, Dhaka',
        ]);

        Donation::create([
            'donor_id'        => $victim2->id,
            'incident_id'     => $incident2->id,
            'title'           => 'Warm Clothing Bundle',
            'description'     => '20 sets of warm clothing for displaced families in Cox\'s Bazar.',
            'category'        => 'clothing',
            'quantity'        => 20,
            'unit'            => 'sets',
            'status'          => 'pledged',
            'pickup_location' => 'Uttara, Dhaka',
        ]);

        
        $task1 = VolunteerTask::create([
            'incident_id'       => $incident1->id,
            'created_by'        => $admin->id,
            'title'             => 'Food Distribution at Sylhet Relief Camp',
            'description'       => 'Volunteers needed to distribute food packets to flood victims at the main relief camp in Sylhet Sadar.',
            'category'          => 'food_distribution',
            'status'            => 'open',
            'volunteers_needed' => 10,
            'volunteers_assigned' => 1,
            'location_name'     => 'Sylhet Sadar Relief Camp',
        ]);

        $task2 = VolunteerTask::create([
            'incident_id'       => $incident2->id,
            'created_by'        => $admin->id,
            'title'             => 'Search and Rescue in Cox\'s Bazar',
            'description'       => 'Help search for missing persons and rescue survivors trapped in damaged structures.',
            'category'          => 'search_rescue',
            'status'            => 'open',
            'volunteers_needed' => 15,
            'volunteers_assigned' => 0,
            'location_name'     => 'Cox\'s Bazar Coastal Area',
        ]);

        
        VolunteerTaskAssignment::create([
            'volunteer_task_id' => $task1->id,
            'user_id'           => $volunteer1->id,
            'status'            => 'assigned',
        ]);
    }
}
