<?php

namespace App\Http\Controllers;

use App\Personagem;
use App\Batalha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BatalhaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $batalha = (new Batalha())->create([
            'token' => md5(uniqid(rand(), true))
        ]);
        $batalha->save();

        $batalha->load('p1')
            ->load('p2');

        return response()->json($batalha);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $token)
    {
        $batalha = (new Batalha())->where('token', $token)->get();
        $batalha->load('p1');
        $batalha->load('p2');
        $batalha->load('rodadas');

        return response()->json($batalha);
    }

    public 

}
