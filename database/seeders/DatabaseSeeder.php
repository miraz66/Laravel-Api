<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Database\Factories\TicketFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory(10)->create();

        Ticket::factory(100)->recycle($user)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('1234qwer'),
        ]);
    }
}
