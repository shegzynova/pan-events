<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function __construct()
    {
        //
    }

    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = ['Select Permission'] + Permission::pluck('name', 'id')->toArray();

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.settings.roles')
            ->with('success','Role created successfully');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = ['Select Permission'] + Permission::pluck('name', 'id')->toArray();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('admin.roles.edit',compact('role','permissions','rolePermissions'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.settings.roles')
            ->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        $role = Role::find($id);

        if ($role) {
            $role->permissions()->sync([]);
            $role->delete();
        }

        return redirect()->route('admin.settings.roles')
            ->with('success','Role deleted successfully');
    }


    public function getModels()
    {
        $models = [];

        $basePath = app_path();

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath));
        $iterator->rewind();

        while ($iterator->valid()) {
            if (
                $iterator->isFile() &&
                $iterator->isReadable() &&
                Str::endsWith($iterator->getBasename(), '.php')
            ) {
                $filePath = $iterator->key();
                $fileContent = file_get_contents($filePath);

                if (preg_match('/\bclass\s+(\w+)\s+extends\s+Model\b/', $fileContent, $matches) && !in_array($matches[1], ['ChMessage', 'ChFavorite'])) {
                    $models[strtolower($matches[1])] = $matches[1];
                }
            }

            $iterator->next();
        }

        return $models;
    }
}
