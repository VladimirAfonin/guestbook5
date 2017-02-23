@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{--<a class="btn btn-primary pull-right" href="{{ url('/admin') }}">Login</a>--}}

            <h1 class="text-center"><small>Guest book</small></h1>

        </div>
    </div>

    <div class="row table">
        @if($comments)
            <div class="text-right"><small>Всего сообщений:</small><i class="badge">{{ $count }}</i></div>
        @endif
        <br>
        @foreach($comments as $comment)
            <div class="panel panel-default item{{ $comment->id }}">
                <div class="panel-heading">
                    <h2 class="panel-title"><small>{{ $comment->name }}</small> <span class="pull-right label label-info">{{ $comment->created_at->diffForHumans() }}</span> </h2>
                </div>
                <div class="panel-body">{{ $comment->text }}</div>
            </div>
        @endforeach
    </div>

    <div class="text-center">{{ $comments->render() }}</div>
    <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
    <br><br><br><br><hr>

    <div class="page-header">
        <h1 class="text-center"><small >Форма добавления комментария</small></h1>
    </div>
    <br><br>

    <div class="msg text-center alert alert-success " style="display:none;">Сообщение успешно добавлено!</div>

    <div class="form-group row add">
        <div class="col-md-3">
            <label for="email">Your Email address*</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Your email here..." required/>
            <p class="erroremail text-center alert alert-danger hidden"></p>
        </div>
        <div class="col-md-7">
            <label for="email">Your comment*</label>
            <textarea class="form-control" rows="4" id="comment" name="text" placeholder="Your comment here..." required></textarea>
            <p class="errortext text-center alert alert-danger hidden"></p>
        </div>
        <div class="col-md-2"><br>
            <button class="btn btn-warning" type="submit" id="useradd">
                <span class="glyphicon glyphicon-plus"></span> Add New Data
            </button>
        </div>
    </div>



@stop