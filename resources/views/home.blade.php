@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Lista de Videos</div>

                <div class="panel-body">
                    @if (session('mensaje'))
                        <div class="alert alert-success">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                </div>
               
                    @foreach($videos as $video)
                            <div class="card">
                               @if(Storage::disk('images')->has($video->image))
                                  <img class="img-thumbnail "  src="{{url('/miniatura/'.$video->image)}}">
                               @endif
                                <div class="card-body">
                                    <a href="{{route('crear-video.show',array("id"=>$video->id))}}"><h2 class="card-title">{{$video->title}}</h2></a>
                                    <p>{{$video->user->name}}</p>
                                    <a href="{{route('crear-video.show',array("id"=>$video->id))}}" class="btn btn-success">Ver</a> 
                                    @if(Auth::check() && Auth::user()->id == $video->user->id)
                                      <a href="{{route('crear-video.edit',array('id'=>$video->id))}}" class="btn btn-warning">Editar</a>  
                                      <form action="{{route('crear-video.destroy',array('id'=>$video->id))}}" method="POST">
                                            {{csrf_field()}} 
                                            {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                    @endforeach
                </ul>
                {{ $videos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
