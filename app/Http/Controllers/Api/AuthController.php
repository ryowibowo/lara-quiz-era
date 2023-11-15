<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules  = [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required']

        ];
        $message = [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa karakter',
            'name.max' => 'Nama maks.  255 karakter',
            'phone_number.required' => 'No Telp harus diisi',
            'phone_number.numeric' => 'Harus Angka',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Email maks. 255 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->passes()) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role_id' => 'b319dbc4-5b29-4eef-9ec9-f83d8cb909a3',
                'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
                'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            ];
            $user = User::create($data);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['status' => 'success', 'access_token' => $token, 'token_type' => 'Bearer']);
        } else {
            return response()->json(['status' => 'success', 'message' => $validator->errors()]);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login information is invalid.'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
