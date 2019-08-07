<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $comment = new Comment();
        $comment->reply = $request->reply;
        $comment->body = $request->body;
        $comment->url = sha1(substr($request->body, 0, 7));
        $comment->news_id = $request->news_id;
        if(Auth::check())
        {
            $comment->user = Auth::id();
            $comment->name = Auth::user()->name;
            $comment->email = Auth::user()->email;
        } else
        {
            $comment->name = $request->name;
            $comment->email = $request->email;
        }
        $save = $comment->save();
        if($save)
        {
            return response()->json(['response' => 'COMMENT_ADD'], 200);
        }
        return response()->json(['response' => 'COMMENT_FAIL'], 500);
    }

    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
