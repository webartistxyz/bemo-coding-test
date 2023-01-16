<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('access_token') != 'oyYfk6DMwgEIItH4Er5eo') {
            return abort(401);
        }

        $cards = Card::query();

        if ($request->has('date')) {
            $cards->whereDate('created_at', $request->get('date'));
        }

        if ($request->has('status')) {
            if ($request->get('status') == 0) {
                $cards->onlyTrashed();
            }
        } else {
            $cards->withTrashed();
        }

        return $cards->get();
    }

    /**
     * Saves the reposisitons
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePositions(Request $request)
    {
        foreach ($request->get('columns', []) as $cards) {
            foreach ($cards as $card) {
                Card::where('id', $card['card_id'])
                    ->update([
                        'position' => $card['position'],
                        'board_column_id' => $card['board_column_id']
                    ]);
            }
        }

        return response()->noContent();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'board_column_id' => 'required',
        ]);

        $column = Card::create(
            array_merge(
                $request->only(['title', 'board_column_id']),
                ['description' => 'This is a new card with simple description', 'position' => 0]
            )
        );

        return $column;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        $card->update($request->only(['title', 'description', 'position']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        $card->delete();
        return response()->noContent();
    }
}
