<?php

use App\DataTables\UsersDataTable;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Gateways\PayPalController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/{id}/edit', function ($id){
    return $id;
})->name('user.edit');

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


/** Image Intervention*/
Route::get('image', function (){
    $imageManager =new ImageManager('gd'); // or 'imagick' for Imagick driver

    // Open an image file
    $image = $imageManager->read('html.jpeg');

    // Crop the image to 400x400 pixels
    $image->crop(400, 400); //crop ,fit , blur (0-100)
    $image->blur(15);
    $image->greyscale();

    // Save the processed image as 'html1.jpeg' with 80% quality
    //$image->save('html1.jpeg', 80); // 0 to 100
    return $image->response();

    $image->filter(new \App\Helpers\ImageFilter(100));

    return 'Image processing completed!';
});



Route::get('shop', [CartController::class, 'shop'])->name('shop');

Route::get('cart', [CartController::class, 'cart'])->name('cart');


Route::get('add-to-cart/{product}', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('qty-increment/{rowId}', [CartController::class, 'qtyIncrement'])->name('qty-increment');
Route::get('qty-decrement/{rowId}', [CartController::class, 'qtyDecrement'])->name('qty-decrement');
Route::get('remove-product/{rowId}', [CartController::class, 'removeProduct'])->name('remove-product');

Route::get('create-role', function (){
    $role = Role::create(['name' => 'publisher']);
    return $role;
});

Route::get('create-permission', function (){
    $permission = Permission::create(['name' => 'edit articles']);
    return $permission;
});

Route::get('add-role', function (){
    $user = auth()->user();

    $user->assignRole('writer');

    return $user;
});


Route::get('add-permission', function (){
    $user = auth()->user();

    return $user->givePermissionTo('edit articles');

    //return $user;
});

Route::get('get-permissions', function (){
    $user = auth()->user();

    return $user->permissions;


});

Route::get('get-roles', function (){
    $user = auth()->user();

    return $user->getRoleNames();

    //eturn $user;
});

Route::get('can', function (){
    $user = auth()->user();

    return $user->can('edit articles');


});

Route::get('check-permissions', function (){
    $user = auth()->user();

    $checkPermission =  $user->can('edit articles');
    if ($user->can('edit articles')){
        return 'user have permission';
    }else{
        return 'user dont have permission';
    }

});


Route::get('posts', function(){

   // $user = auth()->user();

    //$user->assignRole('admin');

    $posts = Post::all();
    return view('post.post', compact('posts'));
});


/**SOCIALITE LOGIN AUTHENTICATION*/
Route::get('/auth/redirect', function(){
    return Socialite::driver('github')->redirect();
})->name('github.login');

Route::get('/auth/callback', function(){
    $user = Socialite::driver('github')->user();

    /*Create new account**/
    $user = User::firstOrCreate([
        'email' => $user->email
    ],[
        'name' => $user->name,
        'password' => bcrypt(Str::random(24))
    ]);

    /*Login the user **/
    Auth::login($user, true);

    /*Redirect to dashboard **/
    return redirect('/dashboard');
});


Route::get('/products', function () {
    return view('index');
});

Route::post('paypal/payment', [PayPalController::class, 'payment'])->name('paypal.payment');

Route::get('paypal/success',  [PayPalController::class, 'success'])->name('paypal.success');
Route::get('paypal/cancel',  [PayPalController::class, 'cancel'])->name('paypal.cancel');






