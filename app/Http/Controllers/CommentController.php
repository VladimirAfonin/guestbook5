<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Response;
use Validator;


class CommentController extends Controller
{
    // admin view.
    public function index()
    {
        $comments = Comment::orderBy('id', 'desc')->paginate(10);
        $count = Comment::count();
        return view('comment.index', ['comments' => $comments, 'count' => $count] );
    }

    // user view.
    public function execute()
    {
        $comments = Comment::orderBy('id', 'desc')->paginate(10);
        $count = Comment::count();
        return view('comment.user', ['comments' => $comments, 'count' => $count] );
    }

    public function editItem(Request $request)
    {
        $comments = Comment::find($request->id);
        $comments->name = $request->name;
        $comments->text = $request->text;
        $comments->save();
        return response()->json($comments);
    }

    public function deleteItem(Request $request)
    {
        Comment::find($request->id)->delete();
        return response()->json();
    }
    // add admin data.
    public function addItem(Request $request)
    {
        $input = $request->except('_token');
        $messages = [
            'required' => ' Поле :attribute обязательно к заполнению!',
            'max' => 'Поле :attribute превысило максимальное число допустимых символов!',
            'unique' => 'Поле :attribute должно быть уникальным!',
            'email' => 'Поле :attribute должно быть формата email'

        ];
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'text' => 'required',
        ], $messages);

        if($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()]);
        } else {
            $comment = new Comment;
            $comment->name = $request->name;
            $comment->email = $request->email;
            $comment->text = $request->text;
            $comment->save();
            return response()->json($comment);
        }
    }

}
