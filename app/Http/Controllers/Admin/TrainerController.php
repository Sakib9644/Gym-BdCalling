<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;


class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::with('user')->get();
        return response()->json($trainers);
    }

    

   

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'trainer';
        $user->save();

        $user->assignRole('trainer');

        $trainer = new Trainer();
        $trainer->user_id = $user->id;
        $trainer->expertise = $request->expertise;
        $trainer->availability = json_encode($request->availability);
        $trainer->save();

        return response()->json($trainer, 201);
    }

    public function show($id)
    {
        $trainer = Trainer::with('user')->findOrFail($id);
        return response()->json($trainer);
    }

    public function update(Request $request, $id)
    {
        $trainer = Trainer::findOrFail($id);
        $user = $trainer->user;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $trainer->expertise = $request->expertise;
        $trainer->availability = json_encode($request->availability);
        $trainer->save();

        return response()->json($trainer);
    }

    public function destroy($id)
    {
        $trainer = Trainer::findOrFail($id);
        $user = $trainer->user;
        $user->delete();
        $trainer->delete();

        return response()->json(null, 204);
    }
}
