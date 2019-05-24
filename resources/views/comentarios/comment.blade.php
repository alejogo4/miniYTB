@if(Auth::check())
    <form action="{{route('comments.store')}}" method="POST">
        {{csrf_field()}}
        <input type="hidden" name="txtIdVideo" value="{{$video->id}}">
        <div class="form-group">
            <textarea name="txtComentario" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success">
        </div>
    </form>
@endif