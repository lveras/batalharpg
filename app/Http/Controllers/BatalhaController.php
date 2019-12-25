<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatalhaRequest;
use App\Http\Resources\BatalhaResource;
use App\Batalha;
use App\Repository\BatalhaRepository;
use Illuminate\Http\Request;


class BatalhaController extends Controller
{
    private $batalha;

    public function __construct(Batalha $batalha)
    {
        $this->batalha = $batalha;
    }

    public function show(Request $request, $token)
    {
        $batalha = $this->batalha->where('token', $token)->first();

        return new BatalhaResource($batalha);
    }

    public function create()
    {
        $batalha = (new Batalha())->create([
            'token' => md5(uniqid(rand(), true))
        ]);
        $batalha->save();
        $batalha->load('p1')->load('p2');

        return (new BatalhaResource($batalha));
    }

    public function roll(Request $request, $token){
        $batalha = $this->batalha->where('token', $token)->first();
        if($batalha == null){
            return response()->json(['message' => 'Token is invalid.']);
        }

        (new BatalhaRepository($batalha))->getResultado();

        return $this->show($request, $token);
    }




}
