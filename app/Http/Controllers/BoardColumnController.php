<?php

namespace App\Http\Controllers;

use App\Models\BoardColumn;
use Illuminate\Http\Request;

class BoardColumnController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['board_id' => 'required', 'name' => 'required|string']);

        $latestColumn = BoardColumn::orderBy('id', 'desc')->first();
        $column = BoardColumn::create(array_merge($request->only(['name', 'board_id']), ['position' => optional($latestColumn)->position+1]));

        return $column;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BoardColumn  $boardColumn
     * @return \Illuminate\Http\Response
     */
    public function show(BoardColumn $boardColumn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BoardColumn  $boardColumn
     * @return \Illuminate\Http\Response
     */
    public function edit(BoardColumn $boardColumn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BoardColumn  $boardColumn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BoardColumn $boardColumn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BoardColumn  $boardColumn
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoardColumn $boardColumn)
    {
        $boardColumn->cards()->delete();
        $boardColumn->delete();

        return response()->noContent();
    }
}
