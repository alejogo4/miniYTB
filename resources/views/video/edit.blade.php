@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h2>Editar - {{$video->title}}</h2>
        </hr>
        <form action="{{ route('crear-video.update',array('id'=>$video->id)) }}" method="POST" enctype="multipart/form-data" class="col-md-7">
            {{method_field('PATCH')}}
            {{csrf_field()}}
            <div class="form-group">
                <label for="titulo">Titulo del video</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="{{$video->title}}">
            </div>
            <div class="form-group">
                    <label for="descripcion">Descripción del video</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" >{{$video->description}}</textarea>
            </div>
            <div class="form-group">
                    <label for="miniatura">Miniatura del video</label>
                    <img class="img-thumbnail "  src="{{url('/miniatura/'.$video->image)}}">
                    <input type="file" class="form-control" id="miniatura" name="miniatura">
            </div>
            <div class="form-group">
                    <label for="video">Archivo Video</label>
                    <video controls id="video_player" width="100%">
                        <source src="{{url('/video-file/'.$video->video_path)}}"> </source>
                    </video>
                    <input type="file" class="form-control" id="video" name="video">
            </div>
            <div class="form-group">
                   
                    <input type="submit" class="btn btn-success" value="Editar Video">
            </div>
          
            @if(empty($errors->all))
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>               
                @endforeach
            @endif
        </form>
    </div>
</div>

@endsection