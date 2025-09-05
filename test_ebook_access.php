<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing E-Book Access...\n";

// Test 1: Check if there are books with e-book files
$booksWithFiles = Book::whereNotNull('file_path')->get();

if ($booksWithFiles->count() > 0) {
    echo "✓ Found {$booksWithFiles->count()} book(s) with e-book files\n";
    
    foreach ($booksWithFiles as $book) {
        echo "\nBook: {$book->title}\n";
        echo "  - File path: {$book->file_path}\n";
        echo "  - Storage exists: " . (Storage::exists($book->file_path) ? 'YES' : 'NO') . "\n";
        
        if (Storage::exists($book->file_path)) {
            echo "  - File size: " . number_format(Storage::size($book->file_path) / 1024, 2) . " KB\n";
            echo "  - MIME type: " . mime_content_type(Storage::path($book->file_path)) . "\n";
            echo "  - Full path: " . Storage::path($book->file_path) . "\n";
        }
    }
} else {
    echo "✗ No books with e-book files found\n";
}

// Test 2: Check storage configuration
echo "\nStorage Configuration:\n";
echo "  - Default disk: " . config('filesystems.default') . "\n";
echo "  - Public disk root: " . config('filesystems.disks.public.root') . "\n";
echo "  - Public disk URL: " . config('filesystems.disks.public.url') . "\n";

// Test 3: Check if storage link exists
$storageLink = public_path('storage');
if (is_link($storageLink)) {
    echo "  - Storage link: EXISTS\n";
    echo "  - Storage link target: " . readlink($storageLink) . "\n";
} else {
    echo "  - Storage link: MISSING\n";
}

// Test 4: Check storage directory permissions
$storagePath = storage_path('app/public');
if (is_dir($storagePath)) {
    echo "  - Storage directory: EXISTS\n";
    echo "  - Storage directory writable: " . (is_writable($storagePath) ? 'YES' : 'NO') . "\n";
} else {
    echo "  - Storage directory: MISSING\n";
}

echo "\nTest completed.\n";
