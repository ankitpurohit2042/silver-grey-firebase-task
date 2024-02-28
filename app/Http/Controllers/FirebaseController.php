<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebaseController extends Controller
{

    private $database;

    public function __construct()
    {
        // $this->database = \App\Providers\FirebaseService::connect();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd("r");
        return response()->json($this->database->getReference('test/blogs')->getValue());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $this->database
                ->getReference('users/'.rand(99,9999))
                ->set($data);
            return response()->json('blog has been created');
        } catch (\Throwable $th) {
            dd($th->getMessage(), $th->getLine());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
