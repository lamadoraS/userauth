<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokens = Token::simplePaginate(5); 
        return view('tokens.index', compact('tokens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Optionally, return a view with a form to create a token.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'expiration' => 'required|date'
        ]);

        // Generate a new token value
        $tokenValue = Str::random(60);

        // Create or update the token for the specified user
        Token::updateOrCreate(
            ['user_id' => $request->input('user_id')],
            ['token_value' => $tokenValue, 'expiration' => $request->input('expiration')]
        );

        return redirect()->route('tokens.index')->with('success', 'Token created/updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Token $token)
    {
        // Optionally, return a view to show token details.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Token $token)
    {
        // Optionally, return a view with a form to edit the token.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Token $token)
    {
        // Optionally, update the token details.
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Token $token)
    {
        $token->delete();
        return redirect()->route('tokens.index')->with('success', 'Token deleted successfully.');
    }
}
