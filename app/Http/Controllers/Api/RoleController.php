<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Exception;

class RoleController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                'status' => true,
                'data'   => Role::with('permissions')->get()
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'        => 'required|unique:roles',
                'permissions' => 'array'
            ]);

            $role = Role::create(['name' => $request->name]);

            if ($request->permissions) {
                $role->syncPermissions($request->permissions);
            }

            return response()->json(['status' => true, 'data' => $role], 201);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Role $role)
    {
        try {
            return response()->json([
                'status' => true,
                'data'   => $role->load('permissions')
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $role->update(['name' => $request->name]);

            if ($request->permissions) {
                $role->syncPermissions($request->permissions);
            }

            return response()->json(['status' => true, 'data' => $role]);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();

            return response()->json(['status' => true, 'message' => 'Role deleted']);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
