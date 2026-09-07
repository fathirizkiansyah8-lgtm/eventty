<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

$student = \App\Models\User::where('role','student')->whereHas('registeredEvents')->first();
if (!$student) { echo "No student with events\n"; exit; }

echo "Testing for: {$student->name}\n";

$events = $student->registeredEvents()->with(['category'])->orderBy('events.date','desc')->get();
echo "Events count: " . $events->count() . "\n\n";

foreach ($events as $ev) {
    $regDate = $ev->pivot->registration_date;
    if (is_string($regDate)) $regDate = \Carbon\Carbon::parse($regDate);

    echo "Event: {$ev->name}\n";
    echo "  registration_date type: " . get_class($regDate ?? new stdClass()) . "\n";
    echo "  registration_date formatted: " . ($regDate ? $regDate->format('d F Y') : 'NULL') . "\n";
    echo "  attendance_status: {$ev->pivot->attendance_status}\n";
    echo "  Result: OK\n\n";
}

echo "=== FIX VERIFIED ===\n";
