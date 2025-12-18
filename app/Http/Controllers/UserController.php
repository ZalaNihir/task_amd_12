<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Qualification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'admin'){
            $users = User::paginate(10);
            return view('users.index', compact('users'));
        }
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->with('qualifications')->first();
        if (!$user) {
            return abort(404);
        }

        return view('users.edit', compact('user'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'phone' => $request->input('phone'),
            'role' => 'user',
        ]);

        Qualification::create([
            'user_id' => $user->id ?? 1,
            'title' => $request->qualifications['title'],
            'institute' => $request->qualifications['institute'],
            'year' => $request->qualifications['year'],
            'grade' => $request->qualifications['grade'],
        ]);

        return redirect()->route('user.index')->with('success', 'User added');
    }

    public function update(UserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = 'user';
        $user->phone = $request->phone;
        $user->save();

        $qualification = Qualification::where('user_id', $user->id)->first();
        $qualification->title = $request->qualifications['title'];
        $qualification->institute = $request->qualifications['institute'];
        $qualification->year = $request->qualifications['year'];
        $qualification->grade = $request->qualifications['grade'];
        $qualification->save();

        return redirect()->route('user.index');

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted');
    }

    public function updateprofile(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id',$id)->first();
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->save();

        Qualification::updateOrCreate(
            [
                'user_id' => $id
            ],[
            'user_id' => $user->id,
            'title' => $request->qualifications['title'],
            'institute' => $request->qualifications['institute'],
            'year' => $request->qualifications['year'],
            'grade' => $request->qualifications['grade'],
        ]);
        return redirect()->back();
    }
}
