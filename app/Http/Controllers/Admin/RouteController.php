<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\Permission\PermissionResource;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = PermissionResource::collection(Permission::latest()->paginate(10));
        return inertia('Rotas/Index', ['permissions' => $permissions]);
    }


            /**
         * Gera a paginação dos itens de um array ou collection.
        *
        * @param array|Collection      $items
        * @param int   $perPage
        * @param int  $page
        * @param array $options
        *
        * @return LengthAwarePaginator
        */
        public function paginate($items, $perPage = 15, $page = null, $options = [])
        {
            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

            $items = $items instanceof Collection ? $items : Collection::make($items);

            return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionsNoInDb = array_values(collect(Route::getRoutes()->get())
        ->map( function($item) {
            return [
                'item' => $item->action['as'] ?? $item->action['uses']
            ];
        })
        ->whereNotIn('item', Permission::all() ->map(function($item){  return $item->name; })
        ->toArray())->toArray());
        // dd($permissionsNoInDb);
        return inertia('Rotas/Create', [
             'permissions' => $permissionsNoInDb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $permission = Permission::create([
            'name' =>  $request->permission,
            'guard_name' => 'web'
        ]);
        if($permission){
            $role = Role::find(1);
            $role->givePermissionTo($permission);
        }
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
