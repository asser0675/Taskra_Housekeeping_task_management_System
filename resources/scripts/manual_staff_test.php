<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$logFile = __DIR__ . '/manual_staff_test.log';
file_put_contents($logFile, "--- manual_staff_test run: " . date('c') . " ---\n", FILE_APPEND);

function logOut($msg) {
    global $logFile;
    echo $msg . "\n";
    file_put_contents($logFile, $msg . "\n", FILE_APPEND);
}

use App\Models\User;
use App\Models\Room;
use App\Models\Task;
use App\Models\Issue;
use Illuminate\Support\Str;

logOut("Starting manual staff flow test...");
try {
    // 1) Find or create housekeeper user
    $email = 'test.housekeeper@example.com';
    $user = User::where('email', $email)->first();
    if (! $user) {
        $user = User::create([
            'name' => 'Test Housekeeper',
            'email' => $email,
            'password' => bcrypt('secret'),
            'role' => 'housekeeper'
        ]);
        logOut("Created user: {$user->email}");
    } else {
        logOut("Found user: {$user->email}");
    }

    // 2) Create a room
    $roomNumber = '999';
    $room = Room::where('room_number', $roomNumber)->first();
    if (! $room) {
        $room = Room::create([
            'room_number' => $roomNumber,
            'status' => 'Dirty'
        ]);
        logOut("Created room: {$room->room_number} (status: {$room->status})");
    } else {
        logOut("Found room: {$room->room_number} (status: {$room->status})");
    }

    // 3) Create a task assigned to the user
    $task = Task::create([
        'room_id' => $room->id,
        'assigned_to' => $user->id,
        'created_by' => $user->id,
        'task_type' => 'Manual Test Task ' . Str::random(4),
        'status' => 'pending',
        'priority' => 'Low'
    ]);
    logOut("Created task id={$task->id}, status={$task->status}");

    // 4) Verify counts
    $tasksForUser = Task::where('assigned_to', $user->id)->get();
    logOut("User has {$tasksForUser->count()} tasks assigned.");

    // 5) Transition to in-progress
    $task->status = 'in-progress';
    $task->save();
    // Update room logic (like controller)
    $room = $task->room;
    if ($room->status !== 'For Maintenance') {
        $room->status = 'In Progress';
        $room->save();
    }
    logOut("Task {$task->id} set to in-progress; room status now: {$room->status}");

    // 6) Transition to completed
    $task->status = 'completed';
    $task->save();
    $room = $task->room;
    if ($room->status !== 'For Maintenance') {
        $room->status = 'Ready';
        $room->save();
    }
    logOut("Task {$task->id} set to completed; room status now: {$room->status}");

    // 7) Report issue for the task (sets room to For Maintenance)
    $issue = Issue::create([
        'task_id' => $task->id,
        'reported_by' => $user->id,
        'description' => 'Automated test reported issue',
        'status' => 'open'
    ]);
    // Controller would set room to For Maintenance
    $room = $task->room;
    $room->status = 'For Maintenance';
    $room->save();
    logOut("Created issue id={$issue->id}; room status now: {$room->status}");

    // 8) Final verification
    $freshTask = Task::find($task->id);
    $freshRoom = Room::find($room->id);
    logOut("Final: task.status={$freshTask->status}, room.status={$freshRoom->status}");

    logOut("Manual staff flow test completed successfully.");
    exit(0);
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
