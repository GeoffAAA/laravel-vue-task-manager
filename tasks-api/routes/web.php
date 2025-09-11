<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Task Manager API',
        'version' => '1.0.0',
        'endpoints' => [
            'authentication' => [
                'POST /api/register' => 'Register new user',
                'POST /api/login' => 'Login user',
                'POST /api/logout' => 'Logout user (requires auth)'
            ],
            'tasks' => [
                'GET /api/tasks' => 'Get user tasks (requires auth)',
                'POST /api/tasks' => 'Create new task (requires auth)',
                'PUT /api/tasks/{id}' => 'Update task (requires auth)',
                'DELETE /api/tasks/{id}' => 'Delete task (requires auth)'
            ]
        ],
        'frontend' => 'http://localhost:5173',
        'documentation' => 'See README.md for usage instructions'
    ]);
});


Route::get('/app/{any}', function ($path) {
    $filePath = public_path('app/' . $path);
    
    // If it's a file that exists, serve it with proper headers
    if (file_exists($filePath) && is_file($filePath)) {
        $mimeType = mime_content_type($filePath);
        return response()->file($filePath, ['Content-Type' => $mimeType]);
    }
    
    // For SPA routing, serve index.html for any non-file requests
    return file_get_contents(public_path('app/index.html'));
})->where('any', '.*');
