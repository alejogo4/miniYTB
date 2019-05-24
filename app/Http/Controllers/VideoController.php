<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


use Illuminate\Support\MessageBag;

use App\Video;
use App\Comment;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index()
    {
        //
        return  view("video.create");
        
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
        //
        $validarData = $this->validate($request,[
            'titulo' => 'required|min:5',
            'descripcion'=>'required',
            'miniatura'=>'required',
            'video'=>'mimes:mp4'
        ]);

        $Video = new Video();
        $usuario = \Auth::user();
        $Video->user_id = $usuario->id;
        //$Video->user_id = 1;
        $Video->title = $request->input('titulo');
        $Video->description = $request->input('descripcion');
        $imagen = $request->file('miniatura');
        if($imagen){
            $ruta_img = $imagen->getClientOriginalName();
            $ruta_img = str_replace(" ","",$ruta_img);
            \Storage::disk('images')->put($ruta_img,\File::get($imagen));

            $Video->image = $ruta_img;
            
        }

        $video_file = $request->file('video');

        if($video_file){
            $video_name = $video_file->getClientOriginalName();
            $video_name = str_replace(" ","",$video_name);
            \Storage::disk('videos')->put($video_name,\File::get($video_file));

            $Video->video_path  = $video_name;
        }
            
        $Video->save();
    
       
       return  redirect()->route('home')->with(array(
           "mensaje"=>"Video Insertado con exito"
        ));
       

    }

    public function getImage($file){

        $file = \Storage::disk('images')->get($file);
        return new Response($file,200);

    }

    public function getVideo($file){
        $file = \Storage::disk('videos')->get($file);
        return new Response($file,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $video = Video::find($id);
        return  view('video.detail', array(
            "video"=>$video
        ));
        
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $video = Video::find($id);
        return  view('video.edit', array(
            "video"=>$video
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $Video = Video::find($id);
        $usuario = \Auth::user();
        $Video->user_id = $usuario->id;
        //$Video->user_id = 1;
        $Video->title = $request->input('titulo');
        $Video->description = $request->input('descripcion');
        $imagen = $request->file('miniatura');
  
        if($imagen){
            \Storage::disk('images')->delete($Video->image);
            $ruta_img = $imagen->getClientOriginalName();
            $ruta_img = str_replace(" ","",$ruta_img);
            \Storage::disk('images')->put($ruta_img,\File::get($imagen));

            $Video->image = $ruta_img;
            
        }

        $video_file = $request->file('video');

        if($video_file){
            \Storage::disk('images')->delete($Video->video_path);
            $video_name = $video_file->getClientOriginalName();
            $video_name = str_replace(" ","",$video_name);
            \Storage::disk('videos')->put($video_name,\File::get($video_file));

            $Video->video_path  = $video_name;
        }
            
        $Video->update();
    
       
       return  redirect()->route('home')->with(array(
           "mensaje"=>"Video Modificado con exito"
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $video = Video::find($id);
        $commentarios = Comment::where('video_id', $id)->get();

        if($commentarios && count($commentarios)>=1){
            Comment::where('video_id', $id)->delete();
        } 

        Storage::disk("images")->delete($video->image);
        Storage::disk("videos")->delete($video->video_path);

        $video->delete();
        return redirect()->action(
            'HomeController@index'
        );

        
    }

    
    public function buscarVideo(Request $request){
        $filtro = $request->input("buscar");
        $videos = Video::where("title","LIKE","%".$filtro."%")->paginate(4);
       return  view('video.edit', array(
            "video"=>$video
        ));
    }



}
