<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\Permission\PermissionResource;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role,$id)
    {
        $role  = $role->with([
            'permissions',
          
        ])->find($id);
        if(!$role){
            return back()->with([
                'type' => 'error',
                'message' => 'Este perfil não existe',
            ]);
        }
        $permissions = PermissionResource::collection(Permission::latest()->paginate(15));

        return inertia('Roles/RoleAddPermission', ['permissions' => $permissions,'role'=> $role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $role = Role::find($request->role);
        $permission = Permission::find($request->id);
        if($request->status == "adicionar")
        {
            $role->givePermissionTo($permission);
        }else{
            $role->revokePermissionTo($permission);
        }
        
        return back()->with([
            'type' => 'success',
            'message' => 'rota inativa',
        ]);
        
        return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
