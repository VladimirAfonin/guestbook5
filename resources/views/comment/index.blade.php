@extends('app')

@section('content')
        {{-- head.--}}
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Guestbook5') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ url('/login') }}">Login</a></li>
                                <li><a href="{{ url('/register') }}">Register</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ url('/logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    {{--/.head--}}

        <!-- admin.table  -->
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Actions</th>
                    </tr>
                    <?php $n = 1; ?>
                    @foreach($comments as $comment)
                        <tr class="item{{ $comment->id }}">
                            <td>{{ $n++ }}</td>
                            <td>{{ $comment->name }}</td>
                            <td><textarea class="form-control" rows="4">{{ $comment->text }}</textarea></td>
                            <td>
                                <button class="edit-modal btn btn-primary" data-id="{{ $comment->id }}" data-name="{{ $comment->name }}" data-comment="{{ $comment->text }}" data-email="{{ $comment->email}}"><span class="glyphicon glyphicon-edit"> </span> Edit</button>
                                <button class="delete-modal btn btn-danger" data-id="{{ $comment->id }}" data-name="{{ $comment->name }}" data-comment="{{ $comment->text }}" data-email="{{ $comment->email}}"><span class="glyphicon glyphicon-trash"> </span> Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <div class="text-center">{{ $comments->render() }}</div>
            </div>
        </div>
        <!-- /. table admin -->

        <br><br><br><br><br>

        <div class="page-header">
            <h1 class="text-center"><small>Оставьте ваш отзыв</small></h1>
        </div>

        <!-- admin.formAdd  -->
        <div class="form-group row add">
            <div class="col-md-2">
                <input class="form-control" id="name" name="name" value="Admin" disabled type="hidden"/>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="email" name="email" placeholder="You email here..." required />
                <p class="erroremail alert alert-danger hidden text-center"></p>
            </div>
            <div class="col-md-5">
                <textarea class="form-control" id="text" name="text"  placeholder="You comment here..." required></textarea>
                <p class="errortext alert alert-danger hidden text-center"></p>
            </div>
            <div class="col-md-3">
                <button class="btn btn-warning" type="submit" id="add"><span class="glyphicon glyphicon-plus"></span> Add new comment </button>
            </div>
        </div>
        <!-- /. admin.formAdd  -->

        <!-- admin.modal  -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button  type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="fid">ID:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fid" disabled/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="n">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="n"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="c">Comment:</label>
                                <div class="col-sm-10">
                                    <textarea  class="form-control" rows="4" id="c"></textarea>
                                </div>
                            </div>
                        </form>

                        <div class="deleteContent">
                            Are you sure you want to delete id - <span class="title"></span> ?
                            <span class="hidden id"></span>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn actionBtn" data-dismiss="modal">
                                <span id="footer_action_button" class='glyphicon'> </span>
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span> Закрыть
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /. admin.modal  -->



@stop