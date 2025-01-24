<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\CategoriesController;
use App\Http\Controllers\backend\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Home
Route::get('/',                 [HomeController::class, 'Home']);
Route::get('/shop',             [HomeController::class, 'Shop']);
Route::get('/product/{slug}',   [HomeController::class, 'Product']);
Route::get('/news',             [HomeController::class, 'News']);
Route::get('/article/{slug}',   [HomeController::class, 'Article']);
Route::get('/search',           [HomeController::class, 'Search']);

// User SignIn & SignUp
Route::get('/signin',         [UserController::class, 'Signin'])->name('login');
Route::post('/signin-submit', [UserController::class, 'SigninSubmit']);

Route::get('/signup',         [UserController::class, 'Signup']);
Route::post('/signup-submit', [UserController::class, 'SignupSubmit']);

// @Middleware Auth
Route::middleware(['auth'])->group(function () {

    // Sample
    Route::get('/admin',                       [AdminController::class, 'index']);
    Route::get('/admin/add-post',              [AdminController::class, 'AddPost']);
    Route::post('/admin/add-post-submit',      [AdminController::class, 'AddPostSubmit']);
    Route::get('/admin/list-post',             [AdminController::class, 'ListPost']);
    
    // User Logout
    Route::get('/signout',                     [UserController::class, 'SignOut']);

    //List Log Activities
    Route::get('/admin/log-activity',          [AdminController::class, 'ViewLog']);

    //Website Logo
    Route::get('/admin/list-logo',              [AdminController::class, 'ListLogo']);
    Route::get('/admin/add-logo',               [AdminController::class, 'AddLogo']);
    Route::post('/admin/add-logo-submit',       [AdminController::class, 'AddLogoSubmit']);
    Route::get('/admin/update-logo/{id}',       [AdminController::class, 'UpdateLogo']);
    Route::post('/admin/update-logo-submit',    [AdminController::class, 'UpdateLogoSubmit']);
    Route::post('/admin/remove-logo-submit',    [AdminController::class, 'RemoveLogoSubmit']);

    //Category
    Route::get('/admin/list-category',               [CategoriesController::class, 'ListCategory']);
    Route::get('/admin/add-category',                [CategoriesController::class, 'AddCategory']);
    Route::post('/admin/add-category-submit',        [CategoriesController::class, 'AddCategorySubmit']);
    Route::get('/admin/update-category/{id}',        [CategoriesController::class, 'UpdateCategory']);
    Route::post('/admin/update-category-submit',     [CategoriesController::class, 'UpdateCategorySubmit']);
    Route::post('/admin/remove-category-submit',     [CategoriesController::class, 'RemoveCategorySubmit']);

    //Attribute
    Route::get('/admin/add-attribute',               [CategoriesController::class, 'AddAttribute']);
    Route::post('/admin/add-attribute-submit',       [CategoriesController::class, 'AddAttributeSubmit']);
    Route::get('/admin/list-attribute',              [CategoriesController::class, 'ListAttribute']);
    Route::get('/admin/update-attribute/{id}',       [CategoriesController::class, 'UpdateAttribute']);
    Route::post('/admin/update-attribute-submit',    [CategoriesController::class, 'UpdateAttributeSubmit']);
    Route::post('/admin/remove-attribute-submit',    [CategoriesController::class, 'RemoveAttributeSubmit']);

    //Product
    Route::get('/admin/list-product',                 [ProductController::class, 'ListProduct']);
    Route::get('/admin/add-product',                  [ProductController::class, 'AddProduct']);
    Route::post('/admin/add-product-submit',          [ProductController::class, 'AddProductSubmit']);
    Route::get('/admin/update-product/{id}',          [ProductController::class, 'UpdateProduct']);
    Route::post('/admin/update-product-submit',       [ProductController::class, 'UpdateProductSubmit']);
    Route::post('/admin/remove-product-submit',       [ProductController::class, 'RemoveProductSubmit']);

});
