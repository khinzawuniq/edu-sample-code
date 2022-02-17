<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:list|create|edit|delete', ['only' => ['index','store']]);
        $this->middleware('permission:create', ['only' => ['create','store']]);
        $this->middleware('permission:edit', ['only' => ['edit','update']]);
        $this->middleware('permission:delete', ['only' => ['destroy']]);
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        $permissions = Permission::get(); //Get all permissions
        return view('admin.permissions.index')->with('permissions', $permissions);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
        $roles = Role::get(); //Get all roles

        return view('admin.permissions.create')->with('roles', $roles);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;
        $permission->save();

        $roles = $request['roles'];

        if (!empty($request['roles'])) { //If one or more role is selected
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
                $r->givePermissionTo($permission);
            }
        }

        flash('Permission created successful!')->success()->important();
        return redirect()->route('permissions.index');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {
        return redirect('admin/permissions');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id) {
        $permission = Permission::findOrFail($id);
        $permission_roles = DB::table('role_has_permissions')->join('permissions as permit', 'permit.id', '=', 'role_has_permissions.permission_id')
        ->where('role_has_permissions.permission_id', $permission->id)
        ->get();
        
        $roles = Role::get();

        return view('admin.permissions.edit', compact('permission','roles','permission_roles'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
        $permission = Permission::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);
        
        $name = $request->name;
        $permission->name = $name;
        $permission->save();

        $roles = $request['roles'];

        if (!empty($request['roles'])) {
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail();
    
                $permission = Permission::where('name', '=', $name)->first();
                $r->givePermissionTo($permission);
            }
        }

        DB::table('role_has_permissions')->whereNotIn('role_id', $roles)->where('permission_id', $permission->id)->delete();
        
        flash('Permission updated successful!')->success()->important();
        return redirect()->route('permissions.index');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id) {
        $permission = Permission::find($id)->delete();

        flash('Permission deleted successful!')->success()->important();
        return redirect()->route('permissions.index');
    }
}
