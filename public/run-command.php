<?php

use Illuminate\Support\Facades\Artisan;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Get the command from the query parameter
$command = $_GET['command'] ?? null;

if ($command) {
    // Handle 'reverb:start' command by running it in the background (Windows)
    if ($command == 'reverb:start') {
        // Background process command for Windows
        $bgCommand = "start php " . __DIR__ . "/../artisan $command";

        // Run the background process
        $result = shell_exec($bgCommand);

        echo "WebSocket server started in the background.\n";
    } else {
        // For other commands, execute normally
        try {
            $output = Artisan::call($command);
            echo "Command executed: {$command}\n";
            echo Artisan::output();
        } catch (Exception $e) {
            echo "Error running command: " . $e->getMessage();
        }
    }
} else {
    echo "No command specified. Use ?command=your-command.";
}
