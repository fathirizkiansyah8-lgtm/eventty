<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        $organizer = User::create([
            'name' => 'Tech Community',
            'email' => 'organizer@example.com',
            'password' => Hash::make('password123'),
            'phone' => '08123456789',
            'role' => 'organizer',
            'is_active' => true,
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'phone' => '08987654321',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create participants
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'Participant ' . $i,
                'email' => 'participant' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'phone' => '0812345678' . $i,
                'role' => 'participant',
                'is_active' => true,
            ]);
        }

        // Create events
        $event1 = Event::create([
            'title' => 'Tech Conference 2024',
            'description' => 'Annual technology conference with leading experts discussing latest trends in tech industry',
            'category' => 'Technology',
            'location' => 'Jakarta Convention Center',
            'start_date' => now()->addDays(15)->toDateString(),
            'end_date' => now()->addDays(17)->toDateString(),
            'start_time' => '08:00',
            'end_time' => '18:00',
            'capacity' => 500,
            'current_participants_count' => 0,
            'organizer_id' => $organizer->id,
            'status' => 'published',
            'is_paid' => false,
            'price' => 0,
        ]);

        $event2 = Event::create([
            'title' => 'Business Networking Summit',
            'description' => 'Networking event for business professionals and entrepreneurs',
            'category' => 'Business',
            'location' => 'Hotel Indonesia Kempinski',
            'start_date' => now()->addDays(20)->toDateString(),
            'end_date' => now()->addDays(20)->toDateString(),
            'start_time' => '09:00',
            'end_time' => '17:00',
            'capacity' => 300,
            'current_participants_count' => 0,
            'organizer_id' => $organizer->id,
            'status' => 'published',
            'is_paid' => true,
            'price' => 150000,
        ]);

        $event3 = Event::create([
            'title' => 'Web Development Workshop',
            'description' => 'Hands-on workshop on modern web development frameworks and best practices',
            'category' => 'Education',
            'location' => 'Tech Hub Jakarta',
            'start_date' => now()->addDays(30)->toDateString(),
            'end_date' => now()->addDays(30)->toDateString(),
            'start_time' => '10:00',
            'end_time' => '16:00',
            'capacity' => 50,
            'current_participants_count' => 0,
            'organizer_id' => $organizer->id,
            'status' => 'published',
            'is_paid' => true,
            'price' => 500000,
        ]);

        // Create registrations for event 1
        $participants = User::where('role', 'participant')->get();
        
        foreach ($participants as $participant) {
            $registration = Registration::create([
                'user_id' => $participant->id,
                'event_id' => $event1->id,
                'registration_date' => now(),
                'registration_number' => 'REG-' . date('YmdHi') . '-' . Str::random(6),
                'payment_status' => 'completed',
                'status' => 'confirmed',
            ]);

            // Create attendance record
            Attendance::create([
                'registration_id' => $registration->id,
                'event_id' => $event1->id,
                'user_id' => $participant->id,
                'qr_code_token' => Str::random(32),
                'status' => 'pending',
            ]);
        }

        // Update event participant count
        $event1->update(['current_participants_count' => $participants->count()]);

        // Create registrations for event 2 (partial)
        $selectedParticipants = $participants->slice(0, 5);
        foreach ($selectedParticipants as $participant) {
            $registration = Registration::create([
                'user_id' => $participant->id,
                'event_id' => $event2->id,
                'registration_date' => now(),
                'registration_number' => 'REG-' . date('YmdHi') . '-' . Str::random(6),
                'payment_status' => 'completed',
                'status' => 'confirmed',
            ]);

            Attendance::create([
                'registration_id' => $registration->id,
                'event_id' => $event2->id,
                'user_id' => $participant->id,
                'qr_code_token' => Str::random(32),
                'status' => 'pending',
            ]);
        }

        $event2->update(['current_participants_count' => $selectedParticipants->count()]);

        // Create registrations for event 3 (few)
        $selectedParticipants3 = $participants->slice(0, 3);
        foreach ($selectedParticipants3 as $participant) {
            $registration = Registration::create([
                'user_id' => $participant->id,
                'event_id' => $event3->id,
                'registration_date' => now(),
                'registration_number' => 'REG-' . date('YmdHi') . '-' . Str::random(6),
                'payment_status' => 'completed',
                'status' => 'confirmed',
            ]);

            Attendance::create([
                'registration_id' => $registration->id,
                'event_id' => $event3->id,
                'user_id' => $participant->id,
                'qr_code_token' => Str::random(32),
                'status' => 'pending',
            ]);
        }

        $event3->update(['current_participants_count' => $selectedParticipants3->count()]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Test Credentials:');
        $this->command->info('Organizer - Email: organizer@example.com, Password: password123');
        $this->command->info('Admin - Email: admin@example.com, Password: password123');
        $this->command->info('Participants 1-10 - Email: participant{1-10}@example.com, Password: password123');
    }
}
