<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function signup(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:user,email',
                'password' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            // Create the user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();


            return response()->json(['message' => 'User registered successfully', 'user' => $user], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'some information are not valid'], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            // Log the exception message for debugging
            \Log::error('User registration error: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}