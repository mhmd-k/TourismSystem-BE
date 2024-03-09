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
                return response()->json(['error' => $validator->errors()->first(), 'status' => 400], Response::HTTP_BAD_REQUEST);
            }

            // Create the user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();


            return response()->json(['message' => 'User registered successfully', 'userId' => $user->id, 'status' => 200], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'some information are not valid', 'status' => 400], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            // Log the exception message for debugging
            \Log::error('User registration error: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage(), 'status' => 500], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}