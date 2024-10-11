<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ATraineeController extends Controller
{
    public function profile()
    {
        $trainee = auth()->user();
       

        return view('frontend.admin.trainee.index',compact('trainee'));
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
        $trainee->password = bcrypt($request->password);
        $trainee->save();

        return back()->with('success','Profile Updated Succesfully');
    }

    public function deleteProfile()
    {
        $trainee = auth()->user();
        $trainee->delete();

        return response()->json(['message' => 'Profile deleted successfully']);
    }
}
