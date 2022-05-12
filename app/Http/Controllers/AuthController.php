<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Admin;

class AuthController extends Controller
{
    //
    public function login(Request $request, $type)
    {
        try {
            $tokenResult = "";

            if ($type == 'admin') {
                $request->validate([
                    'accountname' => 'required',
                    'password' => 'required'
                ]);

                $admin = Admin::where('admin_accountname', $request->accountname)->first();

                if (!$admin && !Hash::check($request->password, $admin->admin_password, [])) {
                    throw new \Exception('Error in Login');
                }

                $tokenResult = $admin->createToken('authTokenAdmin', ['admin'])->plainTextToken;
            } else {
                $request->validate([
                    'email' => 'email|required',
                    'password' => 'required'
                ]);

                $customer = Customer::where('customer_email', $request->email)->first();

                if (!$customer && !Hash::check($request->password, $customer->customer_password, [])) {
                    throw new \Exception('Error in Login');
                }

                $tokenResult = $customer->createToken('authTokenCustomer', ['customer'])->plainTextToken;
            }

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }
    public function signup(Request $request)
    {
        $message = [
            'customer_email.email' => 'Invalid email',
            'customer_email.required' => 'Fill out your email address',
            'customer_password.required' => 'Fill out your email address'
        ];

        $validator = Validator::make($request->all(), [
            'customer_email' => 'email|required',
            'customer_password' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['messages' => $validator->errors()], 404);
        }

        Customer::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_password' => Hash::make($request->customer_password)
        ]);

        return response()->json([
            'messages' => 'Signup success',
            'status_code' => 200
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'messages' => 'Logout success',
            'status_code' => 200
        ]);
    }
}