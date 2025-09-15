<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PosAuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'staff_code' => ['required', 'string'],
            'pin'        => ['required', 'string', 'min:4', 'max:12'],
        ]);

        $user = User::where('pos_code', $data['staff_code'])->first();

        if (!$user || !$user->pos_pin || !Hash::check($data['pin'], $user->pos_pin)) {
            return response()->json(['message' => 'Invalid code or PIN'], 422);
        }

        // Do NOT Auth::login() -> no WEB session for cashiers
        // Issue a POS-scoped token instead
        // (optional) revoke previous POS tokens: $user->tokens()->where('name','pos')->delete();
        $token = $user->createToken('pos', ['pos'])->plainTextToken;

        return response()->json([
            'token'      => $token,
            'user'       => ['id' => $user->id, 'name' => $user->name, 'staff_code' => $user->pos_code],
        ]);
    }

    public function logout(Request $request)
    {
        optional($request->user())->currentAccessToken()?->delete();

        return response()->json(['ok' => true]);
    }

    // Keep this but protect it with admin middleware in routes
    public function listCashiers(Request $request)
    {
        // Optionally enforce here too:
        // abort_unless(optional($request->user('web'))->is_admin, 403);

        $cashiers = User::whereNotNull('pos_code')->get(['id', 'name', 'pos_code']);
        return response()->json($cashiers);
    }
}
