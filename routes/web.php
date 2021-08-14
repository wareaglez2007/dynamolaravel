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





//Route::get('/{slug}', function () {
//  return view('frontend.welcome');
//});

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
/**
 * Modules:
 * Admin Section for Module routes
 */

/**
 * Pages
 * Controller = PagesController
 */



//Route::get('/admin/pages', 'PagesController@index')->name('admin.pages'); //Request page

Route::get('/admin', 'DashboardController@index')->name('admin.home');
Route::get('/admin/pages', 'PagesController@AjaxPublishedPages')->name('admin.pages'); // show the draft pages
Route::get('/admin/pages/drafts', 'PagesController@AjaxDraftPages')->name('admin.pages.draft'); // show the draft pages
Route::get('/admin/pages/trashed', 'PagesController@AjaxTrashedPages')->name('admin.pages.trash'); // show the draft pages


Route::get('/admin/pages/pagetree', 'PagesController@Pagestree')->name('admin.pages.tree');
Route::get('/admin/pages/create', 'PagesController@create')->name('admin.pages.create');
Route::post('/admin/pages/store', 'PagesController@store')->name('admin.pages.store');


Route::get('/admin/pages/show/{id}', 'PagesController@show')->name('admin.pages.show');

Route::get('/admin/pages/edit/{id}', 'PagesController@edit')->name('admin.pages.edit');
//Edit page image view pagination
Route::get('/admin/pages/editpagepaginations/{id}', 'PagesController@PageImagesPagination');

//Edit page file view pagination
Route::get('/admin/pages/editpagepaginations/files/{id}', 'PagesController@PageFilesPagination');

Route::post('/admin/pages/update', 'PagesController@update');

//Atach Image to Page
//DoAttachImages
Route::post('/admin/pages/edit/attachimages', 'PagesController@DoAttachImages');

//Atach Files to Page
//DoAttachFiles
Route::post('/admin/pages/edit/attachfiles', 'PagesController@DoAttachFiles');

Route::post('/admin/pages/delete', 'PagesController@destroy')->name('Backend.Pages.destroy');

Route::post('/admin/pages/forcedelete', 'PagesController@permDelete')->name('Backend.Pages.forcedelete');

Route::put('/admin/pages/restore', 'PagesController@restore')->name('Backend.Pages.restore');
Route::post('/admin/pages/publish', 'PagesController@publish')->name('Backend.Pages.publish');
Route::post('/admin/pages/edit/addimages', 'PagesController@AppendImageToPage')->name('Backend.Pages.doaddimages');
Route::post('/admin/pages/edit/detachimage', 'PagesController@DetachImageFromPage');
Route::post('/admin/pages/edit/detachfile', 'PagesController@DetachFilesFromPage');

Route::post('/admin/pages/update/updateposition', 'PagesController@UpdatePosition');
Route::post('/admin/pages/bulkunpublish', 'PagesController@BulkUnpublish');
Route::post('/admin/pages/bulkpublish', 'PagesController@BulkPublish');

/**
 * Images
 * Controller = ImagesController
 */
Route::get('/admin/Images/uploadimage', 'UploadImagesController@getUploadForm')->name('admin.images.upload');
Route::get('/admin/Images/uploadimagereport', 'UploadImagesController@ViewImagesReports')->name('admin.images.report');
/****Report***/
Route::get('/admin/Images/uploadimagereport/pagination', 'UploadImagesController@ImageReportModulePagination');
/**Image report pagination */
Route::post('/admin/Images/uploadimagereport/detachimage', 'UploadImagesController@DetachImageFromPage');

Route::post('/admin/Images/uploadimage', 'UploadImagesController@postUploadForm');
Route::get('/admin/Images/deleteselectedimage', 'UploadImagesController@DeleteImages');
Route::get('/admin/Images/getafterdelete', 'UploadImagesController@AfterDelete');
Route::post('/admin/Images/updateimagesinfo', 'UploadImagesController@UpdateImages');
/****NEW***/
///admin/Images/uploadimage/pagination
Route::get('/admin/Images/uploadimage/pagination', 'UploadImagesController@ImageModulePagination');

/**
 * Files
 * Controller = FileshandlerController
 */
Route::get('/admin/Files/managefiles', 'FileshandlerController@index')->name('admin.files.upload');
Route::post('/admin/files/uploadfiles', 'FileshandlerController@store')->name('admin.files.upload.save');
/**
 * Navigations Manger
 */

Route::get('/admin/navigations', 'NavigationController@index')->name('admin.navigations');
/**
 * SEO Manger
 */
Route::get('/admin/seo', 'SEOController@index')->name('admin.seo');

/**
 * Social Media Manager
 */
Route::get('/admin/social-media', 'SocialMediaController@index')->name('admin.social');

/**
 * Business Information Manager
 */

Route::get('/admin/business-info', 'LocationsController@index')->name('admin.business');
Route::post('/admin/locations/store', 'LocationsController@store')->name('admin.location.add');
Route::post('/admin/locations/update', 'LocationsController@update')->name('admin.location.add');
Route::post('/admin/locations/destroy', 'LocationsController@destroy')->name('admin.location.del');
//'/admin/locations_hours/destroy'
Route::post('/admin/location_hours/destroy', 'LocationsController@destroylocations')->name('admin.location.del.location');
//'/admin/locations/contacts/add'
Route::post('/admin/locations/contacts/add', 'LocationsController@addContactSection')->name('admin.location.contact');
//'/admin/locations/edit/addstorehoursrows'
Route::post('/admin/locations/edit/addstorehoursrows', 'LocationsController@addstorehoursrow')->name('admin.location.edit.addhoursrow');


/**
 * 07/30/2021
 * Employee Management (under Business module)
 * 1. Index to show when clicked
 * 2. Create new employee and assignments 
 *  1. Upload employee image & other documents 
 * 3. Edit Employees information
 * 4. Delete an employee
 * 
 * 
 */
Route::get('/admin/employees', 'EmployeesController@index')->name('admin.employee');
Route::get('/admin/employees/edit/{id}', 'EmployeesController@edit')->name('admin.employee.edit'); //08-14-2021 (work needed)
Route::post('/admin/employees/validate', 'EmployeesController@validateForms');
Route::post('/admin/employees/add', 'EmployeesController@store');
Route::post('/admin/employees/resetmodal', 'EmployeesController@resetmodal');
Route::post('/admin/employees/destroy', 'EmployeesController@destroy')->name('employee.destroy');


/**
 * Forms Creat/Edit/Delete Manager
 */

Route::get('/admin/forms', 'FormController@index')->name('admin.forms');

/***************************AJAX FOR PAGES**********************/
//validatenewdata
Route::post('/admin/pages/create/validatenewdata', 'PagesController@validateNewPageData')->name('Backend.Pages.validateNewData');
//validatPageSlugUniqueness
Route::post('/admin/pages/create/validateslug', 'PagesController@validatPageSlugUniqueness')->name('Backend.Pages.validateslug');

//Toggle publish or unplish in edit page ajax call
Route::post('/admin/pages/edit/updatestatus', 'PagesController@updatePageStatus');
//is homepage check
Route::post('/admin/pages/edit/homepage', 'PagesController@isHomepage');

//Save new or same slug for edit pages 03-31-2021
Route::post('/admin/pages/edit/editpageslug', 'PagesController@updatePageSlug')->name('Backend.Pages.editSlugs');

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



/************************END OF PAGES***************************/


/**
 * RS 12/14/2020
 * Frontend Section routes
 */
//Route::get('/', function () {
//  return view('frontend.welcome');
//});

Route::get('/', 'FrontendController@index');

Route::get('/{slug}', 'FrontendController@SingleSlug');

Route::get('/page/{id}/preview', 'FrontendController@ShowWithId')->name('previews');





Route::prefix('{any}')->group(function () {
  Route::get('/{slug}', 'FrontendController@MultipleSlugs')->where('slug', '^[a-zA-Z0-9-_\/]+$');
});
