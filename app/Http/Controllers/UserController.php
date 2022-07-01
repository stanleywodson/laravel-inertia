<?php

namespace App\Http\Controllers;


use App\Models\User;
//use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Http\Resources\User\UserResource;




class UserController extends Controller
{

    public function index()
    {
        $users = UserResource::collection(User::latest()->paginate(10));
        $roles = Role::all();
        return inertia('Users/Index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function store(UserRequest $request)
    {
        $attr = $request->toArray();
        $user = User::create($attr);
        $this->syncRole($request,$user);
        return back()->with([
            'type' => 'success',
            'message' => 'User has been created',
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $attr = $request->toArray();
        $user->update($attr);
        $this->syncRole($request,$user);
        return back()->with([
            'type' => 'success',
            'message' => 'User has been updated',
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with([
            'type' => 'success',
            'message' => 'User has been deleted',
        ]);
    }

    private function syncRole($request,$user)
    {
        $role = Role::find($request->role);
        if($role){
            $user->syncRoles([$role->name]);
        }
    }
}
