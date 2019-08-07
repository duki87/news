<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Auth;
use Session;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

     public function create(Request $request)
     {
         $newLike = new Like();
         if(Auth::check())
         {
           $like = Like::where(['comment' => $request->comment_id, 'user' => Auth::id()])->first();
           if($like)
           {
               $like->delete();
               return response()->json(['response' => 'UNLIKE'], 200);
           }
           $newLike->comment = $request->comment_id;
           $newLike->user = Auth::id();
           $newLike->save();
           return response()->json(['response' => 'LIKE'], 200);
         }
         $like = Like::where(['comment' => $request->comment_id, 'session' => Session::getId()])->first();
         if($like)
         {
             $like->delete();
             return response()->json(['response' => 'UNLIKE'], 200);
         }
         $newLike->comment = $request->comment_id;
         $newLike->user = 0;
         $newLike->session = Session::getId();
         $newLike->save();
         return response()->json(['response' => 'LIKE'], 200);
     }

    public function store(Request $request)
    {
        //
    }

    public static function isLiked($comment, $user, $session)
    {
        if($user == 0) {
          $like = Like::where(['comment' => $comment, 'session' => $session])->first();
          if(!$like) {
            return false;
          }
          return true;
        }
        $like = Like::where(['comment' => $comment, 'user' => $user])->first();
        if(!$like) {
          return false;
        }
        return true;

        // $like = Like::where(['comment' => $comment, 'user' => $user])->first();
        // if(!$like) {
        //   $like = Like::where(['comment' => $comment, 'session' => $user])->first();
        //   if(!$like) {
        //     return false;
        //   } else {
        //     return true;
        //   }
        // } else {
        //   return true;
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //
    }
}
