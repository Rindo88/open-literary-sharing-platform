<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Check if user already exists
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            $existingUser->update([
                'role' => 'admin',
                'password' => Hash::make($password)
            ]);
            $this->info("User {$email} updated to admin role with new password.");
        } else {
            User::create([
                'name' => 'Administrator',
                'email' => $email,
                'username' => 'admin',
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            $this->info("Admin user {$email} created successfully.");
        }

        return 0;
    }
}
