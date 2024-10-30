<?php

use Illuminate\Support\Facades\Route;

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);

Route::get('/discord', function () {
    return redirect('https://discord.gg/CV7n3jVDh7');
});
