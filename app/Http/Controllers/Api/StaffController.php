<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    // List all staff
    public function index()
    {
        try {
            $staffs = User::latest()->get();
            return response()->json($staffs, 200);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Failed to fetch staff', 
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Store a new staff
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:15|unique:users,phone',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|string|min:6',
                'address' => 'nullable|string',
                'qualification' => 'nullable|string',
                'alt_phone' => 'nullable|string|max:15',
                'role' => 'nullable|string|max:255', 
            ]);

            $staff = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'phone' => $validated['phone'],
                'address' => $validated['address'] ?? null,
                'qualification' => $validated['qualification'] ?? null,
                'alt_phone' => $validated['alt_phone'] ?? null,
                'role' => $validated['role'] ?? 'telecaller', 
                'status' => 1,
            ]);

            // Assign role
            $roleName = $validated['role'] ?? 'telecaller';
            $role = Role::findByName($roleName, 'web');
            $staff->assignRole($role);

            return response()->json($staff->load('roles'), 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed', 
                'messages' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Failed to create staff', 
                'details' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong', 
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // Show a specific staff
    public function show($id)
    {
        try {
            $staff = User::with('roles')->findOrFail($id);
            return response()->json($staff, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Staff not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }

    // Update a staff
    public function update(Request $request, $id)
    {
        try {
            $staff = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($staff->id)],
                'phone' => ['sometimes','required','string','max:15', Rule::unique('users')->ignore($staff->id)],
                'address' => 'nullable|string',
                'qualification' => 'nullable|string',
                'alt_phone' => 'nullable|string|max:15',
                'role' => 'sometimes|required|string|max:255',
                'password' => 'nullable|string|min:6|confirmed', // password optional
                'password_confirmation' => 'nullable|string|min:6',
            ]);

            // Update password if provided
            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']); // remove if empty
            }

            // Remove password_confirmation from update array
            unset($validated['password_confirmation']);

            $staff->update($validated);

            // Update role if provided
            if (isset($validated['role'])) {
                $role = Role::findByName($validated['role'], 'web');
                $staff->syncRoles($role); // remove old roles and assign new
            }

            return response()->json($staff->load('roles'), 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed', 
                'messages' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Staff not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update staff', 'details' => $e->getMessage()], 500);
        }
    }

    // Delete a staff
    public function destroy($id)
    {
        try {
            $staff = User::findOrFail($id);
            $staff->delete();
            return response()->json(['message' => 'Staff deleted successfully'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Staff not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete staff', 'details' => $e->getMessage()], 500);
        }
    }

    // Toggle staff status
    public function toggleStatus($id)
    {
        $staff = User::find($id);

        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }

        // Toggle status: 1 = active, 0 = inactive
        $staff->status = $staff->status ? 0 : 1;
        $staff->save();

        return response()->json([
            'message' => 'Staff status updated successfully',
            'status' => $staff->status,
        ]);
    }
}
