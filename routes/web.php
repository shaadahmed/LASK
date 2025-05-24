<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/telescope-login', function () {
    $user = User::where('email', 'superadmin@cms.com')->first();
    Auth::login($user);

    return redirect('/telescope');
})->middleware('web');

Route::get('logs', function () {
    if (!app()->environment(['local', 'development'])) {
        abort(403);
    }
    return app()->call('Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
})->middleware('web');