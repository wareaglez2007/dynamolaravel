<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UploadImages;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;



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
            'image_path' => public_path('images/'),
            'thumbnail_path' => public_path('images/thumbs/')
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
                // you can also use the original name
                $imageName = time() . '-' . $file->getClientOriginalName();
                // save original image
                $image->save($this->imagesPath . $imageName);
                $image_width = getimagesize($file)[0];
                $image_height = getimagesize($file)[1];
                if ($image_width > 150) {
                    $image->resize($image_width / 4, $image_height / 4);
                }
                // resize and save thumbnail

                $image->save($this->thumbnailPath . $imageName);

                $upload = new UploadImages();
                $upload->file = $imageName;
                $upload->save();
            }


            if (count($request->upload) == 1) {
                $success_message = "Image has been uploaded.";
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
}
