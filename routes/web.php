<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* Group Middleware */
Route::group(['middleware' => 'auth-check'] ,  function (){
    /*  Dashboard */
    Route::get('/dashboard', function (){
        return view('dashboard');
    });

    /*  Profile */
    Route::get('/profile', function (){
        return view('profile');
    });
});

Route::middleware([\App\Http\Middleware\AuthCheck::class])->group(function () {
    /*  Dashboard */
    Route::get('/dashboard', function (){
        return view('dashboard');
    });

    /*  Profile */
    Route::get('/profile', function (){
        return view('profile');
    });
});


/*  Trashed  Posts*/
Route::get('/posts/trash', [PostController::class, 'trashed'])->name('posts.trashed');

/*  Restore Trashed Posts*/
Route::get('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

/*  Delete the record permanently*/
Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('force-delete');

Route::resource('posts', PostController::class);

Route::get('/unavailable' , function (){
    return view('unavailable');
})->name('unavailable');

/*Rendering Blade Components*/

Route::get('contact', function (){

    $posts =  \App\Models\Post::all();
    return view('contact', compact('posts'));
});

/*Send Email**/
Route::get('send-email', function (){
    /*Mail Facedes*/
    \Illuminate\Support\Facades\Mail::raw('Hello world this is  a  test  mail', function ($message){
        $message->to('test@gmail.com')->subject('noreplay');
    });
    dd('success');
});

/*Send Email by class**/
Route::get('email-send', function (){
    \Illuminate\Support\Facades\Mail::send(new \App\Mail\OrderShipped);
    dd('success');
});

/*Send Email with attachment**/
Route::get('email-attachment', function (){
    \Illuminate\Support\Facades\Mail::send(new \App\Mail\OrderShipped);
    dd('success');
});

/**retrieving session*/
Route::get('get-session', function (\Illuminate\Http\Request  $request){
    //$data = session()->all();

    $data = $request->session()->all();

    //$data = $request->session()->get('_token');

    dd($data);
});

/**store session*/
Route::get('save-session', function (\Illuminate\Http\Request  $request){
    session(['user_id' => '123']);
    $request->session()->put(['user_status' => 'logged_in']);

    /**global*/
   session(['user_ip' => '123.23.12.01']);

      return redirect('get-session');
});

/**delete session*/
Route::get('delete-session', function (\Illuminate\Http\Request  $request){
    /**via request - string/array*/
    //$request->session()->forget('user_id');
    //$request->session()->forget(['user_id','user_status']);

    /**Session -string/array */
    //session()->forget('user_id');
    //session()->forget(['user_id','user_status']);
    return redirect('get-session');

    /*Delete everything from the session*/
    session()->flush();

    //$request->session()->flush();
    return redirect('get-session');
});


/**flash session data*/
Route::get('flash-session',function (\Illuminate\Http\Request  $request){
    $request->session()->flash('status' ,'true');

    return redirect('get-session');
});

