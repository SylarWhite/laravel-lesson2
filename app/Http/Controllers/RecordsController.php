<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RecordsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     * @param $user
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $records = $user->records()->get();
        return view('records.index',compact('records','user'));
    }


}
