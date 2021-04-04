<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UploadImages;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
        $images = UploadImages::orderBy('id', 'DESC')->get();
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
        //  dd($request->upload);
        $request->validate([
            'upload.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($request->hasFile('upload')) {
            $this->createDirecrotory();
            foreach ($request->upload as $file) {
                $image = Image::make($file);
                $image_extension = $file->extension();
                // you can also use the original name
                $image_hashName = Str::random(50);
                $imageName = time() . '-' . $image_hashName.".".$image_extension;
                // save original image
               // $file->storeAs('/public/uploads/' , $imageName);
               // Storage::url($imageName);

                $image->save($this->imagesPath .$imageName);
                $image_width = getimagesize($file)[0];
                $image_height = getimagesize($file)[1];
                if ($image_width > 150) {
                    $image->resize($image_width / 4, $image_height / 4);
                }
                // resize and save thumbnail
               // $file->storeAs('/public/uploads/thumbnails/' , $imageName);
               // Storage::url($imageName);
                $image->save($this->thumbnailPath .$imageName);

                $upload = new UploadImages();
                $upload->file = $imageName;
                $upload->image_hash = $image_hashName;
                $upload->path_to = $this->imagesPath;
                $upload->image_original_name = $file->getClientOriginalName();
                $upload->image_width = $image_width;
                $upload->image_height = $image_height;
                $upload->save();
            }


            if (count($request->upload) == 1) {
                $success_message = "Image has been uploaded. ".Storage::url($imageName);
            } else {
                $success_message = "Images have been uploaded.";
            }
            $images = UploadImages::orderBy('id', 'DESC')->get();
            if ($request->ajax()) {


                return response()->json([
                    'view' => view('admin.layouts.partials.imageuploadsection')->with(['images' => $images])->render(), 'success' => $success_message
                ]);

                // return response()->json(['success' => $success_message])
                // return view('admin.layouts.partials.uploadimages',['mod_name' => "Images",  'images' => $images])->render();
            }

            // return response()->json(['success' => $success_message]);

        }
    }

        //Deleting IMAGES
        public function DeleteImages(Request $request){

            //Delete File directory
            //file $request->path_to, may need to substring the trailing slash

           Storage::disk('public')->delete($request->image_name); //Deletes the files
           Storage::disk('public')->delete('thumbnails/'.$request->image_name); //Deletes the files
           // Storage::disk('public')->delete('images/'.$request->image_name); // Deletes the directory



            //GET it from AJAX
            UploadImages::where('id', $request->id)->forceDelete();
            $success_message = "Image $request->image_name has been deleted!!!";
            $images = UploadImages::orderBy('id', 'DESC')->get();
            if ($request->ajax()) {
                return response()->json([
                    'view' => view('admin.layouts.partials.imageuploadsection')->with(['images' => $images])->render(), 'success' => $success_message
                ]);


            }

        }
}
