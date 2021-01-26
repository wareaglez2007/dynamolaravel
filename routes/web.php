<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

/**
 * RS 12/14/2020
 * Frontend Section routes
 */
Route::get('/', function () {
    return view('frontend.welcome');
});

/********************************************************/

/**
 * RS 12/14/2020
 * Admin Section routes
 * Auth required for access
 */

Auth::routes();
/**
 * Dashborard
 * Controller = HomeController
 */

Route::get('/admin/home', 'HomeController@index')->name('admin.home');
/**
 * Modules:
 * Admin Section for Module routes
 */

/**
 * Pages
 * Controller = PagesController
 */



//Route::get('/admin/pages', 'PagesController@index')->name('admin.pages'); //Request page
Route::get('/admin/pages', 'PagesController@AjaxPublishedPages')->name('admin.pages'); // show the draft pages
Route::get('/admin/pages/drafts', 'PagesController@AjaxDraftPages')->name('admin.pages.draft'); // show the draft pages
Route::get('/admin/pages/trashed', 'PagesController@AjaxTrashedPages')->name('admin.pages.draft'); // show the draft pages


Route::get('/admin/pages/pagetree', 'PagesController@Pagestree')->name('admin.pages.tree');
Route::get('/admin/pages/create', 'PagesController@create')->name('admin.pages.create');
Route::post('/admin/pages/store', 'PagesController@store')->name('admin.pages.store');


Route::get('/admin/pages/show/{id}', 'PagesController@show')->name('admin.pages.show');

Route::get('/admin/pages/edit/{id}', 'PagesController@edit')->name('admin.pages.edit');

Route::post('/admin/pages/update', 'PagesController@update');

Route::post('/admin/pages/delete', 'PagesController@destroy')->name('Backend.Pages.destroy');

Route::post('/admin/pages/forcedelete', 'PagesController@permDelete')->name('Backend.Pages.forcedelete');

Route::put('/admin/pages/restore', 'PagesController@restore')->name('Backend.Pages.restore');
Route::post('/admin/pages/publish', 'PagesController@publish')->name('Backend.Pages.publish');
Route::post('/admin/pages/edit/addimages', 'PagesController@AppendImageToPage')->name('Backend.Pages.doaddimages');
Route::post('/admin/pages/edit/dettachimage', 'PagesController@DettachImageFromPage');

Route::post('/admin/pages/update/updateposition', 'PagesController@UpdatePosition');
Route::post('/admin/pages/bulkunpublish', 'PagesController@BulkUnpublish');
Route::post('/admin/pages/bulkpublish', 'PagesController@BulkPublish');


Route::get('/admin/Images/uploadimage', 'UploadImagesController@getUploadForm')->name('admin.images.upload');
Route::post('/admin/Images/uploadimage', 'UploadImagesController@postUploadForm');





/***************************AJAX FOR PAGES**********************/
//validatenewdata
Route::post('/admin/pages/create/validatenewdata', 'PagesController@validateNewPageData')->name('Backend.Pages.validateNewData');
//validatPageSlugUniqueness
Route::post('/admin/pages/create/validateslug', 'PagesController@validatPageSlugUniqueness')->name('Backend.Pages.validateslug');

/* 1. Get Draft pages by ID
 * 2. Get new count for Published, Draft and Deleted pags
 * 3. Get
 */

Route::get('/admin/pages/draft/{id}/{status}', 'PagesController@getDraftpageByID');

Route::get('/admin/pages/all/todelete/{id}/{parent}', 'PagesController@getAllNoneDeletedPagesByID');

Route::get('/admin/pages/all/deleted/date/{id}/', 'PagesController@getDeletedAtInfoAfterDelete');

Route::get('/admin/pages/all/trashed/{id}', 'PagesController@getAllTrashedpagesBYID');

Route::get('/admin/pages/published/count', 'PagesController@getNewPublishedCount');

/************************END OF PAGES***************************/

/**
 * Images
 * Controller = ImagesController
 */

/************************END OF PAGES***************************/
