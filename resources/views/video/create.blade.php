@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h2>Subir un nuevo video</h2>
        </hr>
        <form action="{{ route('crear-video.store') }}" method="POST" enctype="multipart/form-data" class="col-md-7">
            {{csrf_field()}}
            <div class="form-group">
                <label for="titulo">Titulo del video</label>
                <input type="text" class="form-control" id="titulo" name="titulo">
            </div>
            <div class="form-group">
                    <label for="descripcion">Descripción del video</label>
                    <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>
            <div class="form-group">
                    <label for="miniatura">Miniatura del video</label>
                    <input type="file" class="form-control" id="miniatura" name="miniatura">
            </div>
            <div class="form-group">
                    <label for="video">Archivo Video</label>
                    <input type="file" class="form-control" id="video" name="video">
            </div>
            <div class="form-group">
                   
                    <input type="submit" class="btn btn-success" value="Crear Video">
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