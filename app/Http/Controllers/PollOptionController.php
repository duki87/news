<?php

namespace App\Http\Controllers;

use App\PollOption;
use Illuminate\Http\Request;

class PollOptionController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:admin');
    }

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
        //
    }

    public function show(PollOption $pollOption)
    {
        //
    }

    public function edit(PollOption $pollOption)
    {
        //
    }

    public function update(Request $request, PollOption $pollOption)
    {
        //
    }

    public function destroy(PollOption $pollOption)
    {
        //
    }
}
