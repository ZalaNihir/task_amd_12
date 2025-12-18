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
        if (Auth::user()->role->name == 'ADMIN') {
            $users = User::paginate(10);
            return view('users.index', compact('users'));
        }
        return abort(401);
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
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        if ($request->has('qualifications')) {
            foreach ($request->qualifications as $qualification) {
                $user->qualifications()->create([
                    'title' => $qualification['title'] ?? null,
                    'institute' => $qualification['institute'] ?? null,
                    'year' => $qualification['year'] ?? null,
                    'grade' => $qualification['grade'] ?? null,
                ]);
            }
        }

        return redirect()->route('user.index')
            ->with('success', 'User added successfully');
    }


    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => $request->filled('password')
                ? bcrypt($request->password)
                : $user->password,
        ]);

        $existingIds = $user->qualifications()->pluck('id')->toArray();
        $submittedIds = [];

        if ($request->has('qualifications')) {
            foreach ($request->qualifications as $qualification) {
                if (!empty($qualification['id'])) {
                    $submittedIds[] = $qualification['id'];

                    Qualification::where('id', $qualification['id'])
                        ->where('user_id', $user->id)
                        ->update([
                            'title' => $qualification['title'],
                            'institute' => $qualification['institute'],
                            'year' => $qualification['year'],
                            'grade' => $qualification['grade'],
                        ]);
                } else {
                    $user->qualifications()->create([
                        'title' => $qualification['title'],
                        'institute' => $qualification['institute'],
                        'year' => $qualification['year'],
                        'grade' => $qualification['grade'],
                    ]);
                }
            }
        }
        $toDelete = array_diff($existingIds, $submittedIds);
        Qualification::whereIn('id', $toDelete)->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'User updated successfully');
    }


    public function destroy($id)
    {
        $user = User::with('qualifications')->findOrFail($id);
        $user->qualifications()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'User deleted.');
    }

    public function updateprofile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $qualifications = $request->qualifications ?? [];

        foreach ($qualifications as $qual) {
            if (isset($qual['id'])) {
                $q = Qualification::find($qual['id']);
                if ($q) {
                    $q->update([
                        'title' => $qual['title'],
                        'institute' => $qual['institute'],
                        'year' => $qual['year'],
                        'grade' => $qual['grade'],
                    ]);
                }
            } else {
                if (!empty($qual['title']) && !empty($qual['institute'])) {
                    Qualification::create([
                        'user_id' => $user->id,
                        'title' => $qual['title'],
                        'institute' => $qual['institute'],
                        'year' => $qual['year'],
                        'grade' => $qual['grade'],
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
