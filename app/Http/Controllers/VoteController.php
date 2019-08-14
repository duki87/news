<?php

namespace App\Http\Controllers;

use App\Vote;
use App\PollOption;
use App\Poll;
use Illuminate\Http\Request;
use Auth;
use Session;

class VoteController extends Controller
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //check if exist
        if(Auth::check())
        {
            $exist = Vote::where(['user' => Auth::id(), 'poll' => $request->poll_id])->first();
            if($exist)
            {
                return response()->json(['response' => 'VOTED'], 500);
            }
        } else {
            $exist = Vote::where(['session' => Session::getId(), 'poll' => $request->poll_id])->first();
            if($exist)
            {
                return response()->json(['response' => 'VOTED'], 500);
            }
        }

        $vote = new Vote();
        $vote->poll = $request->poll_id;
        $vote->vote = $request->option_id;
        if(Auth::check())
        {
            $vote->user = Auth::id();
        }
        else
        {
            $vote->session = Session::getId();
        }
        if($vote->save())
        {
            return response()->json(['response' => 'VOTE_ADD'], 200);
        }
        else
        {
            return response()->json(['response' => 'VOTE_FAIL'], 500);
        }
    }

    public function show($id)
    {
        $votes_sum = Vote::where(['poll' => $id])->count();
        $options = PollOption::where(['poll' => $id])->with('votes')->get();
        $array = array();
        foreach($options as $option)
        {
            $round = count($option->votes)/$votes_sum * 100;
            //$array[] = [$option->option => round($round)];
            $array[] = ['title' => $option->option, 'result' => round($round)];
        }
        return response()->json(['poll_votes' => $array], 200);
    }

    public function edit(Vote $vote)
    {
        //
    }

    public function update(Request $request, Vote $vote)
    {
        //
    }

    public function destroy(Vote $vote)
    {
        //
    }
}
