@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <h2>{{$video->title}}</h2>
        <br>
        <br>
        <div class="col-md-8">
            <video controls id="video_player" width="100%">
                <source src="{{url('/video-file/'.$video->video_path)}}"> </source>
            </video>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Subido Por : {{$video->user->name}} - {{$video->user->surname}} - {{\FormatTime::LongTimeFilter($video->created_at)}}
                </div>
                <div class="panel-body">
                    {{$video->description}}
                </div>
            </div>
            <hr>
            <h4>Comentarios</h4>
            <hr> @include('comentarios.comment');
        </div>
        <div class="col-md-4 comment-video">
            @foreach($video->comments as $comment)
            <div class="panel panel-default">
                <div class="panel-heading">
                    Comentario Por : {{$comment->user->name}} - {{$comment->user->surname}} - {{\FormatTime::LongTimeFilter($comment->created_at)}}
                    @if(Auth::user()->id == $comment->user->id)
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteComment{{$comment->id}}">
                            Eliminar
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalDeleteComment{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Eliminar Comentario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Realmente deseas eliminar el comentario
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <form action="{{route('comments.destroy',array('id'=>$comment->id))}}" method="POST">
                                            {{csrf_field()}} {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="panel-body">
                    {{$comment->body}}
                </div>
            </div>
            @endforeach


        </div>
    </div>
</div>

@endsection