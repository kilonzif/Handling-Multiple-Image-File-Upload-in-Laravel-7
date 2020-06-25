<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
       return view('document');
   }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveDocument(Request $request){

       //validate the files
       $this->validate($request,[
           'image' =>'required',
           'image.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'

       ]);
       if ($request->hasFile('image')) {
           $image = $request->file('image');
           foreach ($image as $files) {
               $destinationPath = 'public/files/';
               $file_name = time() . "." . $files->getClientOriginalExtension();
               $files->move($destinationPath, $file_name);
               $data[] = $file_name;
           }
       }
       $file= new Document();
       $file->name=json_encode($data);
       $file->save();

       return back()->withSuccess('Great! Image has been successfully uploaded.');
   }

}
