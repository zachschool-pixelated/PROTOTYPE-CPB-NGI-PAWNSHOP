<?php

use App\Models\User;

require __DIR__ . '/bootstrap/app.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = User::where('email', 'puffingdev@gmail.com')->first();

if ($user) {
    $user->update(['role' => 'admin']);
    echo "✅ User role updated to admin!\n";
    echo "User: {$user->name} ({$user->email})\n";
    echo "Role: {$user->role}\n";
} else {
    echo "❌ User not found!\n";
}
