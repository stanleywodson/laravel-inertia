<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{

    // use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', -1);
    
        app()['cache']->forget('spatie.permission.cache');

        $routes = collect(Route::getRoutes()->get())->map( function($item) {
            return [
                'prefix' => $item->action['prefix'] ?? false,
                'controller' => $item->action['controller'] ?? false,
                'as' => $item->action['as'] ?? false,
            ];
        })->toArray();

        foreach ($routes as $key => $route) :
            if (!Permission::where(['name' => $route['controller'], 'guard_name' => 'web'])->first()) {
                Permission::create([
                    'name' =>  $route['as'] != false ?  $route['as'] : $route['controller'],
                    'guard_name' => 'web'
                ]);
            }
        endforeach;

        $arrayPerfil = [
            User::SUPER => 'super',
            User::ADMIN => 'admin'
        ];

        foreach ($arrayPerfil as $id => $name):
            $role = Role::create(['id' => $id, 'name' => $name]);
            $role->givePermissionTo(Permission::all());
        endforeach;

        $user1 = User::create([
            'name' => 'odair',
            'username' => 'oobnet',
            'email' => 'oob@dev.test',
            'password' => 123123,
            'email_verified_at' => date("Y-m-d H:i:s")
        ]);
        // bcrypt('secret')
        // 'password', [
        //     'rounds' => 12,
        // ]
        $user2 = User::create([
            'name' => 'oobnet-admin',
            'username' => 'oobnet-admin',
            'email' => 'admin@dev.test',
            'password' => 123123,
            'email_verified_at' => date("Y-m-d H:i:s")
        ]);

    
    
        $user1->assignRole(1);
        $user2->assignRole(2);
    }
}
