<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ATrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::with('user')->get();
        return view('frontend.admin.index', compact('trainers'));
    }
    public function index2()
    {
        $trainers = Trainer::where('user_id', Auth::user()->id)->get();
        
        return view('frontend.admin.trainer_index', compact('trainers'));
    }
    public function create()
    {
        return view('frontend.admin.create');
    }

    public function store(Request $request)
    {
        $trainer = Role::firstOrCreate(['name' => 'trainer'], ['guard_name' => 'api']);

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        //     'expertise' => 'required|string|max:255',
        //     'availability' => 'required|array',
        // ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'trainer';
        $user->save();

        $user->assignRole( $trainer);

        $trainer = new Trainer();
        $trainer->user_id = $user->id;
        $trainer->expertise = $request->expertise;
        $trainer->availability = json_encode($request->availability);
        $trainer->save();

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer created successfully.');
    }

    public function show($id)
    {
        $trainer = Trainer::with('user')->findOrFail($id);
        return view('frontend.admin.show', compact('trainer'));
    }

    public function edit($id)
    {
        $trainer = Trainer::with('user')->findOrFail($id);
        return view('frontend.admin.edit', compact('trainer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'expertise' => 'required|string|max:255',
            'availability' => 'required|array',
        ]);

        $trainer = Trainer::findOrFail($id);
        $user = $trainer->user;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        $trainer->expertise = $request->expertise;
        $trainer->availability = json_encode($request->availability);
        $trainer->save();

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer updated successfully.');
    }

    public function destroy($id)
    {
        $trainer = Trainer::findOrFail($id);
        $trainer->delete();

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer deleted successfully.');
    }
}
