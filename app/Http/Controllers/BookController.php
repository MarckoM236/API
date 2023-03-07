<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Carbon;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //get all
    public function index()
    {
        $booksData=Book::get();

        return response()->json($booksData);
    }

    //get by id
    public function show($id){
        
        $booksData=Book::find($id);

        return response()->json($booksData);
        
    }

    //Insert new data
    public function store(Request $request){
        $bookData= new Book();
        $response=null;

        //validate image
        if($request->hasFile('image')){

            $fileName=$request->file('image')->getClientOriginalName();
            $newFileName=Carbon::now()->timestamp."_".$fileName;
            $destinationFolder='./upload/';
            $request->file('image')->move($destinationFolder,$newFileName);

            $bookData->title=$request->title;
            $bookData->image=ltrim($destinationFolder,'.').$newFileName;

            if($bookData->save()){
                $response = [
                    "status" => "OK",
                    "message" => "Registo Exitoso",
                ];
            }
            else{
                $response = [
                    "status" => "Fail" ,
                    "message" => "Recurso no creado",
                ];
            }
        }
        
        return response()->json($response);
    }

    //update data
    public function update(Request $request,$id){
        $bookData=Book::find($id);
        $response=null;

        if($request->hasFile('image')){
            if($bookData){
                $filePath=base_path('public').$bookData->image;
    
                if(file_exists($filePath)){
                    unlink($filePath);
                }
                $bookData->delete();
            }

            $fileName=$request->file('image')->getClientOriginalName();
            $newFileName=Carbon::now()->timestamp."_".$fileName;
            $destinationFolder='./upload/';
            $request->file('image')->move($destinationFolder,$newFileName);
            $bookData->image=ltrim($destinationFolder,'.').$newFileName;
        }
        if($request->input('title')){
            $bookData->title=$request->input('title');
        }

        //Response
        if($bookData->save()){
            $response = [
                "status" => "OK",
                "message" => "Actualizacion Exitosa",
            ];
        }
        else{
            $response = [
                "status" => "Fail" ,
                "message" => "Recurso no Actualizado",
            ];
        }
        return response()->json($response);
    }

    //Delete data
    public function destroy($id){
        $response=null;
        $booksData=Book::find($id);
        if($booksData){
            $filePath=base_path('public').$booksData->image;

            if(file_exists($filePath)){
                unlink($filePath);
            }

            if($booksData->delete()){
                $response = [
                    "status" => "OK",
                    "message" => "Se elimino Exitosamente",
                ];
            }
            else{
                $response = [
                    "status" => "Fail" ,
                    "message" => "Error al Eliminar",
                ];
            }
            
        }  
        return response()->json($response); 
    }

    //
}