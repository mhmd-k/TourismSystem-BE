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
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => 400
                ], Response::HTTP_BAD_REQUEST);
            }

            // Create the user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $token = base64_encode($request->name . ":" . $request->password);

            return response()->json([
                'message' => 'User registered successfully',
                'status' => 200,
                'data' => [
                    'username' => $user->name,
                    'email' => $user->email,
                    'image' => null,
                    'token' => $token,
                ],
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {

            return response()->json([
                'message' => 'some information are not valid',
                'status' => 400
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            // Log the exception message for debugging
            \Log::error('User registration error: ' . $e->getMessage());

            return response()->json(
                ['message' => $e->getMessage(), 'status' => 500],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'message' => $validator->errors()->first(),
                        'status' => 400
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $user = User::where('email', $request->email)->first();

            // if the user exists in the DB
            if ($user && Hash::check($request->password, $user->password)) {

                $token = base64_encode($user->name . ":" . $request->password);

                return response()->json([
                    "message" => "Login successful! Welcome back.",
                    "status" => Response::HTTP_OK,
                    'data' => [
                        'username' => $user->name,
                        'email' => $user->email,
                        'image' => null,
                        'token' => $token,
                    ],
                ]);
            } else {
                return response()->json([
                    "message" => "Wrong email or password",
                    "status" => Response::HTTP_BAD_REQUEST
                ]);
            }

        } catch (ValidationException $e) {
            return response()->json(
                [
                    'message' => $e->getMessage(),
                    'status' => Response::HTTP_BAD_REQUEST
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

}