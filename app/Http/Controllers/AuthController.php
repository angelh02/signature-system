<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;
use Nowakowskir\JWT\TokenEncoded;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function googleLogin(){
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback(Request $request) {
        try{
            $adwords_api_response = Socialite::with('google')->getAccessTokenResponse($request->code);

            //Consume api
            $client = new Client();

            $url = "http://trsffirmadigitalserviciocertificadosv.eba-4hsuxaba.us-west-1.elasticbeanstalk.com/api/Auth/LoginExternal";
            $headers = [
                'Accept' => '*/*',
                'Content-Type' => 'application/json'
            ];

            $response = $client->request('POST', $url, [
                'json' => $adwords_api_response['id_token'],
                'headers' => $headers,
                'verify'  => false,
            ]);

            $responseBody = json_decode($response->getBody());

            $tokenPayload = new TokenEncoded($responseBody->token);

            $userData = $tokenPayload->decode()->getPayload();

            $user = User::where([['aws_user_id', $userData['UserId']], ['active', true]])->first();
            if(!$user)
                return redirect('/login')->with('user', 'El usuario no existe');

            Auth::loginUsingId($user->id);
            if(!(Auth::check()))
                return redirect('/login')->with('user', 'El usuario no existe');

            $user->aws_auth_token = $responseBody->token;
            $user->save();
            return redirect('/');
        }
        catch(\Exception $e){
            return redirect('/login')->with('user', 'El usuario no existe');
        }
    }
}
