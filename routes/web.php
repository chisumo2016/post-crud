<?php

use App\DataTables\UsersDataTable;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (UsersDataTable $dataTable) {
    $users = \App\Models\User::paginate(10);
    return $dataTable->render('dashboard');
   // return view('dashboard', compact('users'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



/** GROUP  ROUTES*/
Route::group(['middleware' => 'auth'] , function (){

    /** CRUD  ROUTES*/
    /*  Trashed  Posts*/
    Route::get('/posts/trash', [PostController::class, 'trashed'])->name('posts.trashed');

    /*  Restore Trashed Posts*/
    Route::get('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

    /*  Delete the record permanently*/
    Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('force-delete');

    Route::resource('/posts', PostController::class);
});



Route::get('/unavailable' , function (){
    return view('unavailable');
})->name('unavailable');

Route::get('user-data', function (){
    return auth()->user();
});


/*Send Email**/
Route::get('send-email', function (){

        /**Dispatching  Job*/
        \App\Jobs\SendMail::dispatch();
    dd('Mail has been send');
});

/**Event and Listerners*/
Route::get('user-register', function (){
    $email = 'test@gmail.com';
  event(new \App\Events\UserRegistered($email));

    dd('Message has been send');
});


/**Localization en, hi*/
Route::get('greeting', function (){
    return view('greetings');

    //dd('Message has been send');
});

/**Localization en, hi*/
Route::get('greeting-dynamically/{locale}', function ($locale){

    \Illuminate\Support\Facades\App::setLocale($locale);
    return view('greetings');

    //dd('Message has been send');
})->name('greeting-dynamically');
