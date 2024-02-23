<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
            return response()->json($response, 400);
        }

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User registered successfully'
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }

    /**
     * Login an existing user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();

            if (!$user) {
                $response = [
                    'success' => false,
                    'message' => 'Unauthorized',
                ];
                return response()->json($response, 400);
            }

            try {
                $success['token'] = $user->createToken('MyApp')->plainTextToken;
                $success['name'] = $user->name;

                $response = [
                    'success' => true,
                    'data' => $success,
                    'message' => 'User logged in successfully'
                ];

                return response()->json($response, 200);
            } catch (\Exception $e) {
                return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorized',
            ];
            return response()->json($response, 400);
        }
    }
}
