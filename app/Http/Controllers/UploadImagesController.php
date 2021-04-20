<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UploadImages;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Jsonable;
use App\page_images;
use App\pages;

class UploadImagesController extends Controller
{
    public $imagesPath = '';
    public $thumbnailPath = '';



    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Upload form
     */
    public function getUploadForm()
    {
        $images = UploadImages::orderBy('id', 'DESC')->paginate(18);
        //return view('admin.layouts.partials.controller', compact('images'))->render();
        return view("admin.modules.general", ['mod_name' => "Images",  'images' => $images]);
    }
    /**
     * @function CreateDirectory
     * create required directory if not exist and set permissions
     */
    public function createDirecrotory()
    {
        $paths = [
            'image_path' => storage_path('app/public/'),
            'thumbnail_path' => storage_path('app/public/thumbnails/')
        ];
        foreach ($paths as $key => $path) {
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        }
        $this->imagesPath = $paths['image_path'];
        $this->thumbnailPath = $paths['thumbnail_path'];
    }
    /**
     * Post upload form
     */
    public function postUploadForm(Request $request)
    {
        $upload_messages = [];

        if ($request->hasFile('upload')) {
            $this->createDirecrotory();
            foreach ($request->upload as $key => $file) {
                $value_array = ['upload' => $file];
                $val_messages = [
                    'max' => 'Error on image: ' . $file->getClientOriginalName() . ' The upload may not be greater than 2048 kilobytes.'
                ];
                $rules = ['upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',];
                $validator = Validator::make($value_array, $rules, $val_messages);
                if ($validator->fails()) {
                    $upload_messages[$key] = $validator->errors();
                } else {
                    $upload_messages[$key] = "Image " . $file->getClientOriginalName() . " has been uploaded.";
                    $image = Image::make($file);
                    $image_extension = $file->extension();
                    // you can also use the original name
                    $image_hashName = Str::random(50);
                    $imageName = time() . '-' . $image_hashName . "." . $image_extension;
                    // save original image
                    // $file->storeAs('/public/uploads/' , $imageName);
                    // Storage::url($imageName);

                    $image->save($this->imagesPath . $imageName);
                    $image_width = getimagesize($file)[0];
                    $image_height = getimagesize($file)[1];
                    if ($image_width > 150) {
                        $image->resize($image_width / 4, $image_height / 4);
                    }
                    // resize and save thumbnail
                    // $file->storeAs('/public/uploads/thumbnails/' , $imageName);
                    // Storage::url($imageName);
                    $image->save($this->thumbnailPath . $imageName);

                    $upload = new UploadImages();
                    $upload->file = $imageName;
                    $upload->image_hash = $image_hashName;
                    $upload->path_to = $this->imagesPath;
                    $upload->image_original_name = $file->getClientOriginalName();
                    $upload->image_width = $image_width;
                    $upload->image_height = $image_height;
                    $upload->save();
                }
            }
            $images = UploadImages::orderBy('id', 'DESC')->paginate(18);
            if ($request->ajax()) {


                return response()->json([
                    'view' => view('admin.layouts.partials.Mods.Images.imageuploadsection')->with(['images' => $images])->render(), 'validations' => $upload_messages, 'image_count' => count($request->upload)
                ]);
            }
        }
    }

    //Deleting IMAGES
    public function DeleteImages(Request $request)
    {
        $response_messages = [];
        //We need to check if the image is assigned to a page
        $check_assignment = page_images::where('upload_images_id', $request->id)->count();
        if ($check_assignment > 0) {
            $response_messages['errors'] = 'Image ' . $request->image_origin_name . ' cannot be deleted because it has been assigned to a page';
        } else {
            //Delete File directory
            //file $request->path_to, may need to substring the trailing slash

            Storage::disk('public')->delete($request->image_name); //Deletes the files
            Storage::disk('public')->delete('thumbnails/' . $request->image_name); //Deletes the files
            // Storage::disk('public')->delete('images/'.$request->image_name); // Deletes the directory



            //GET it from AJAX
            UploadImages::where('id', $request->id)->forceDelete();
            $response_messages['success'] = "Image " . $request->image_origin_name . " has been deleted!!!";
        }
        $count = UploadImages::count();

        $images = UploadImages::orderBy('id', 'DESC')->paginate(18);


        if ($request->ajax()) {
            return response()->json([
                'view' => view('admin.layouts.partials.Mods.Images.imageuploadsection')->with(['images' => $images])->render(), 'response' => $response_messages, 'count' => $count
            ]);
        }
    }
    public function AfterDelete(Request $request)
    {
        $count = UploadImages::count();

        $images = UploadImages::orderBy('id', 'DESC')->paginate(18);


        if ($request->ajax()) {
            return response()->json([
                'view' => view('admin.layouts.partials.Mods.Images.imageuploadsection')->with(['images' => $images])->render(), 'count' => $count
            ]);
        }
    }


    /**
     * This function will update information about the image
     */
    public function UpdateImages(Request $request, UploadImages $uploadImages)
    {


        $uploadImages->where('id', $request->id)->update(['image_original_name' => $request->image_name, 'image_alt_text' => $request->image_alt_text]);

        $success_message = "Image $request->image_name has been Updated.";

        if ($request->ajax()) {
            return response()->json([
                'success' => $success_message
            ]);
        }
    }
    /**
     * AJAX Pagination control for Upload images module
     */
    public function ImageModulePagination(Request $request)
    {
        $images = UploadImages::orderBy('id', 'DESC')->paginate(18);

        if ($request->ajax()) {
            return response()->json([
                'view' => view('admin.layouts.partials.Mods.Images.imageuploadsection')->with(['images' => $images])->render()
            ]);
        }
    }

    /**
     * Images Report
     * ViewImagesReports
     */
    public function ViewImagesReports(pages $pages, page_images $page_images, Request $request)
    {
        if(!isset($request->sortby)){
            $request->sortby = 'pages_id';
            $request->direction = 'ASC';
        }
        $request->session()->put('sortby', $request->sortby);
        $request->session()->put('direction', $request->direction);

        //Get Attached Images to each Page
        $report = $page_images->with('attachedPages')->with('getImages')->orderBy($request->sortby, $request->direction )->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'view' => view('admin.layouts.partials.Mods.Images.imagesreporttable')->with(['mod_name' => "Images Report",  'report' => $report])->render()
            ]);
        }else{
            return view("admin.modules.general", ['mod_name' => "Images Report",  'report' => $report]);
        }



    }

    /**
     * Images Report Pagination
     * ImageReportModulePagination
     */
    public function ImageReportModulePagination(Request $request)
    {

       // dd($request->session()->get('direction'));
        //Get Attached Images to each Page
        $report = page_images::with('attachedPages')->with('getImages')->orderBy($request->sortby, $request->direction )->paginate(10);
        if ($request->ajax()) {
            return response()->json([
                'view' => view('admin.layouts.partials.Mods.Images.imagesreporttable')->with(['mod_name' => "Images Report",  'report' => $report])->render()
            ]);
        }
    }

        /**
     * DetachImageFromPage
     */

    public function DetachImageFromPage(Request $request, page_images $page_images){
        $response_messages = [];

        //Check if image is in the table
        $check = $page_images->where("upload_images_id", $request->image_id)->where("pages_id", $request->page_id)->count();
        if($check > 0){
            //lets delete that row from table
            $page_images->where("upload_images_id", $request->image_id)->where("pages_id", $request->page_id)->forceDelete();
            $response_messages['success'] = "Image has been detached from page.";
            $report = page_images::with('attachedPages')->with('getImages')->paginate(10);
        }else{
           $response_messages['error'] = "An error has occured during this query request.";
        }

        if ($request->ajax()) {
           return response()->json([
               "response" => $response_messages,
               'view' => view('admin.layouts.partials.Mods.Images.imagesreporttable')->with([
                   "report" => $report,
               ])->render()
           ]);
       }

    }
}
