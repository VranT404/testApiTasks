<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Get a list of all users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $users = User::orderBy('id', 'desc')->get();

            if ($users->isEmpty()) {
                return response()->json(['response' => 'No users'], 404);
            }

            return response()->json(['users' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }

    /**
     * Get information about a specific user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($userId)
    {
        try {
            $user = User::findOrFail($userId);

            if ($user->isEmpty()) {
                return response()->json(['response' => 'Could not find user for this id'], 404);
            }

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }

    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $authController = new AuthController;
            $user = $authController->register($request);

            return response()->json(['user' => $user, 'message' => 'User created successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }

    /**
     * Update user information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        if ($user->isEmpty()) {
            return response()->json(['response' => 'Could not find user for this id'], 404);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'c_password' => $request->filled('password') ? 'required|same:password' : '',
        ]);

        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }

            $user->update($userData);

            return response()->json(['user' => $user, 'message' => 'User updated successfully'], 200);
        } catch (ValidationException $e) {
            $response = [
                'success' => false,
                'message' => $e->validator->errors()->first(),
            ];

            return response()->json($response, 400);
        }
    }

    /**
     * Delete a user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($userId)
    {
        try {
            $user = User::findOrFail($userId);

            if ($user->isEmpty()) {
                return response()->json(['response' => 'Could not find user for this id'], 404);
            }

            $user->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }
}
