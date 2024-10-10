<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TraineeController extends Controller
{
    public function profile()
    {
        $trainee = auth()->user();
        $response = [
            'name' => $trainee->name,
            'email' => $trainee->email,
        ];

        return response()->json($response);
    }
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $trainee = auth()->user();
        $trainee->name = $request->name;
        $trainee->email = $request->email;
        $trainee->save();

        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function deleteProfile()
    {
        $trainee = auth()->user();
        $trainee->delete();

        return response()->json(['message' => 'Profile deleted successfully']);
    }
}
