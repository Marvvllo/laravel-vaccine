<?php

namespace App\Http\Controllers;

use App\Models\Regionals;
use App\Models\Societies;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $cardNumber = $request->input('id_card_number');
        $password = $request->input('password');

        if (Societies::find($cardNumber) == null || Societies::find($cardNumber)->password != $password) {
            return response('ID Card Number or Password incorrect', 401);
        }

        $society = Societies::find($cardNumber);
        $society->login_tokens = md5($society->id_card_number);
        $society->save();
        $region = Regionals::find($society->regional_id);

        return response([
            'name' => $society->name,
            'born_date' => $society->born_date,
            'gender' => $society->gender,
            'address' => $society->address,
            'token' => $society->login_tokens,
            'regional' => $region,
        ], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->query('token');
        $society = Societies::where('login_tokens', $token)->first();
        if (
            Societies::where('login_tokens', $token)->first() == null
            || Societies::where('login_tokens', $token)->first()->login_tokens != $token
        ) {
            return response([
                'message' => 'Invalid token'
            ], 401);
        }

        $society->login_tokens = "";
        $society->save();

        return response([
            'message' => 'Logout success'
        ], 200);
    }
}
