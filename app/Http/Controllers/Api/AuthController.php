<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Mail\ResetPasswordViaMail;
use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\returnArgument;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthRequest $request)
    {

        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user' => $user,
            'token' => $token
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255']
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function resetPassword(Request $request)
    {

        $data = $request->validate([
            'email' => ['string', 'required', 'max:250']
        ]);

        $user = DB::table('users')
            ->where('email', $data['email'])
            ->first();

        if (!$user) {
            response()->json(['Error' => 'Email Not Found']);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );


        try {
            Mail::to($user->email)->queue(new ResetPasswordViaMail($token, $user->email));
        } catch (\Exception $e) {
            return response()->json(['Error' => 'Mail service problem: ' . $e->getMessage()], 500);
        }
        return response()->json(['status' => 'success']);



    }



    public function updatePassword(Request $request)
    {

        $data = $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $checkResetTable = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        if (!$checkResetTable) {
            return response()->json(['Error' => 'Unauthorized'], 401);
        }

        $expire = Carbon::parse($checkResetTable->created_at)->addMinutes(10);

        if (Carbon::now()->gt($expire)) {
            return response()->json(['Error' => 'Token is Expire'], 403);
        }

        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($data['password'])
            ]);

        DB::table('password_reset_tokens')
            ->where('email', $data['email'])
            ->delete();

        return response()->json(['success' => 'Password Updated'], 201);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'logout success',
        ], 200);
    }
}
