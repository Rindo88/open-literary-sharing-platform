<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Admin Login...\n";

// Test 1: Check if admin user exists
$adminUser = User::where('email', 'admin@perpustakaan.com')->first();

if ($adminUser) {
    echo "✓ Admin user found\n";
    echo "  - Name: {$adminUser->name}\n";
    echo "  - Email: {$adminUser->email}\n";
    echo "  - Role: {$adminUser->role}\n";
    echo "  - Password hash: " . substr($adminUser->password, 0, 20) . "...\n";
    
    // Test 2: Verify password
    if (Hash::check('admin123', $adminUser->password)) {
        echo "✓ Password verification successful\n";
    } else {
        echo "✗ Password verification failed\n";
    }
    
    // Test 3: Try to authenticate
    if (auth()->attempt(['email' => 'admin@perpustakaan.com', 'password' => 'admin123'])) {
        echo "✓ Authentication successful\n";
        echo "  - Authenticated user: " . auth()->user()->name . "\n";
        echo "  - User role: " . auth()->user()->role . "\n";
    } else {
        echo "✗ Authentication failed\n";
    }
    
} else {
    echo "✗ Admin user not found\n";
}

echo "\nTest completed.\n";
