<?php

namespace App\Http\Controllers;

use App\fileshandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class FileshandlerController extends Controller
{
    public $filesPath = '';
    public $csspath = '';
    public $jspath = '';
    public $htmlpath = '';
    public $pdfpath = '';
    public $xmlpath = '';
    public $csvpath = '';
    public $txtpath = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.modules.general", ['mod_name' => "Files Manager"]);
    }


    /**
     * @function CreateDirectory
     * create required directory if not exist and set permissions
     */
    public function createDirecrotory()
    {
        $paths = [
            'file_path' => storage_path('app/public/files'),
            'css_path' => storage_path('app/public/files/css'),
            'js_path' => storage_path('app/public/files/js'),
            'html_path' => storage_path('app/public/files/html'),
            'pdf_path' => storage_path('app/public/files/pdf'),
            'xml_path' => storage_path('app/public/files/xml'),
            'csv_path' => storage_path('app/public/files/csv'),
            'txt_path' => storage_path('app/public/files/txt'),
        ];
        foreach ($paths as $key => $path) {
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        }
        $this->filesPath = $paths['file_path'];
        $this->csspath =  $paths['css_path'];
        $this->jspath = $paths['js_path'];
        $this->htmlpath = $paths['html_path'];
        $this->pdfpath = $paths['pdf_path'];
        $this->xmlpath = $paths['xml_path'];
        $this->csvfpath = $paths['csv_path'];
        $this->txtpath = $paths['txt_path'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $upload_messages = [];

        if ($request->hasFile('upload')) {
            $this->createDirecrotory();
            foreach ($request->upload as $key => $file) {
                $value_array = ['upload' => $file];
                $val_messages = [
                    'max' => 'Error on file: ' . $file->getClientOriginalName() . ' The upload may not be greater than 2048 kilobytes.'
                ];
                $rules = ['upload' => 'required|mimes:css,js,html,xml,csv,pdf,txt|max:2048',];
                $validator = Validator::make($value_array, $rules, $val_messages);

                if ($validator->fails()) {
                    $upload_messages[$key] = $validator->errors();
                } else {
                    $upload_messages[$key] = "File " . $file->getClientOriginalName() . " has been uploaded.";
                    $filename = time().'-'.$file->getClientOriginalName();

                    //Check file extension
                    if($file->extension() == "css"){
                        $file->storeAs($this->csspath , $filename);
                    }
                    if($file->extension() == "js"){
                        $file->storeAs($this->jspath , $filename);
                    }
                    if($file->extension() == "html"){
                        $file->storeAs($this->htmlpath , $filename);
                    }
                    if($file->extension() == "xml"){
                        $file->storeAs($this->xmlpath, $filename);
                    }
                    if($file->extension() == "csv"){
                        $file->storeAs($this->csvpath , $filename);
                    }
                    if($file->extension() == "pdf"){
                        $file->storeAs($this->pdfpath , $filename);
                    }
                    if($file->extension() == "txt"){
                        $file->storeAs($this->txtpath , $filename);
                    }

                    $file_extension = $file->extension();

                    // save original image
                    // $file->storeAs('/public/uploads/' , $imageName);
                   $storedURL =  Storage::url($filename);
                    $file_size = filesize($file);



                    $upload = new fileshandler();
                    $upload->file_name = $filename;
                    $upload->extension = $file_extension;
                    $upload->storage_path = $storedURL;
                    $upload->file_size = $file_size;
                    $upload->save();
                }
            }
            $fetch_files = fileshandler::orderBy('id', 'DESC');
            if ($request->ajax()) {


                return response()->json([
                    'view' => view('admin.layouts.partials.imageuploadsection')->with(['images' => $fetch_files])->render(), 'validations' => $upload_messages, 'image_count' => count($request->upload)
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fileshandler  $fileshandler
     * @return \Illuminate\Http\Response
     */
    public function show(fileshandler $fileshandler)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fileshandler  $fileshandler
     * @return \Illuminate\Http\Response
     */
    public function edit(fileshandler $fileshandler)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fileshandler  $fileshandler
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, fileshandler $fileshandler)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fileshandler  $fileshandler
     * @return \Illuminate\Http\Response
     */
    public function destroy(fileshandler $fileshandler)
    {
        //
    }
}
