<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\IndexPageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubcategoryController;
use App\Http\Controllers\admin\BlogsController;
use App\Http\Controllers\admin\AdminUserController;


Route::middleware(['admin.guest'])->group(function (){
    Route::get('/admin/login',[AdminController::class,'login'])->name('admin.login');
    Route::post('/admin/login/authentication', [AdminController::class, 'authentication'])->name('admin.login.authentication');
});

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::delete('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // category routes
    Route::get('/admin/categories',[CategoryController::class,'listCategory'])->name('admin.categories.listCategory');
    Route::get('/admin/category',[CategoryController::class,'add_category'])->name('admin.add.category');
    Route::post('/admin/category',[CategoryController::class,'store_category'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit',[CategoryController::class,'edit_category'])->name('admin.category.edit');
    Route::put('/admin/category/{id}',[CategoryController::class,'update_category'])->name('admin.category.update');
    Route::delete('/admin/category/{id}',[CategoryController::class,'destroy_category'])->name('admin.category.destroy');

    // subcategory routes
    Route::get('/admin/subcategories',[SubcategoryController::class,'listSubcategory'])->name('admin.subcategories.list');
    Route::get('/admin/subcategory/add',[SubcategoryController::class,'add_subcategory'])->name('admin.add.subcategory');
    Route::post('/admin/subcategory',[SubcategoryController::class,'store_subcategory'])->name('admin.subcategory.store');
    Route::get('/admin/subcategory/{id}/edit',[SubcategoryController::class,'edit_subcategory'])->name('admin.subcategory.edit');
    Route::put('/admin/subcategory/{id}',[SubcategoryController::class,'update_subcategory'])->name('admin.subcategory.update');
    Route::delete('/admin/subcategory/{id}',[SubcategoryController::class,'destroy_subcategory'])->name('admin.subcategory.destroy');

    // blog routes
    Route::get('/admin/blogs',[BlogsController::class,'index'])->name('admin.blogs.index');
    Route::get('/admin/blogs/drafts',[BlogsController::class,'drafts'])->name('admin.blogs.drafts');
    Route::get('/admin/blogs/trash',[BlogsController::class,'trash'])->name('admin.blogs.trash');
    Route::get('/admin/blog/create',[BlogsController::class,'create'])->name('admin.blog.create');
    Route::post('/admin/blog',[BlogsController::class,'store'])->name('admin.blog.store');
    Route::get('/admin/blog/{id}/edit',[BlogsController::class,'edit'])->name('admin.blog.edit');
    Route::put('/admin/blog/{id}',[BlogsController::class,'update'])->name('admin.blog.update');
    Route::delete('/admin/blog/{id}',[BlogsController::class,'destroy'])->name('admin.blog.destroy');
    Route::post('/admin/blog/{id}/restore',[BlogsController::class,'restore'])->name('admin.blog.restore');
    Route::delete('/admin/blog/{id}/force-delete',[BlogsController::class,'forceDelete'])->name('admin.blog.forceDelete');

    // user management routes (admin only)
    Route::get('/admin/users',[AdminUserController::class,'index'])->name('admin.users.index');
    Route::get('/admin/users/create',[AdminUserController::class,'create'])->name('admin.users.create');
    Route::post('/admin/users',[AdminUserController::class,'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit',[AdminUserController::class,'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}',[AdminUserController::class,'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}',[AdminUserController::class,'destroy'])->name('admin.users.destroy');
});

Route::get('/', [IndexPageController::class, 'index'])->name('home');
// Route::get('/blog', [BlogController::class, 'Blog'])->name('blog');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/term-condition', [PageController::class, 'term_conditions'])->name('term_conditions');

Route::get('/{cate_subcate}', [BlogController::class, 'Blog'])->name('categoryblogs')->where('cate_subcate', '[a-zA-Z0-9\-]+');
Route::get('/{cate_subcate}/{blog_slug}', [BlogController::class, 'BlogDetails'])->name('blogdetails')->where('cate_subcate', '[a-zA-Z0-9\-]+')->where('blog_slug', '[a-zA-Z0-9\-]+');
