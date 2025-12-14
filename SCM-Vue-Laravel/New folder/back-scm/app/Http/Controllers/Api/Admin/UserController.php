<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Depo; // ✅ Depo Model যোগ করা হলো
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Only these roles can be assigned by admin during create/edit
    protected $editableRoles = ['admin', 'depo', 'distributor']; 

    /**
     * Display a listing of the resource (Users List).
     * GET /api/admin/users
     */
    public function index()
    {
        // ✅ roles এবং depo লোড করা হলো
        $users = User::with('roles', 'depo')->orderBy('id', 'desc')->get()->map(function ($user) {
            $role = $user->roles->first();
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                // ✅ ডিপো তথ্য যোগ করা হলো
                'depo_name' => $user->depo ? $user->depo->name : 'N/A', 
                // If no role exists, return 'none'
                'role' => $role ? $role->slug : 'none', 
                'roles' => $user->roles, // UserList.vue-এর জন্য roles array দরকার
            ];
        });
        
        return response()->json($users);
    }

    /**
     * Store a newly created resource (Create User).
     * POST /api/admin/users
     */
    public function store(Request $request)
    {
        // 1. Validation 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Only valid roles allowed
            'role' => ['required', Rule::in($this->editableRoles)], 
            
            // ✅ Depo/Distributor রোলের জন্য depo_id Validation
            'depo_id' => [
                Rule::requiredIf(in_array($request->role, ['depo', 'distributor'])), // Depo বা Distributor হলে depo_id লাগবে
                'nullable', 
                'exists:depos,id'
            ],
        ]);
        
        DB::beginTransaction();

        try {
            // 2. User তৈরি করা
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'depo_id' => $request->depo_id, // ✅ depo_id সেভ করা হলো
            ]);

            // 3. Role অ্যাসাইন করা
            $role = Role::where('slug', $request->role)->firstOrFail();
            $user->roles()->attach($role);

            DB::commit();

            return response()->json($user->load('roles', 'depo'), 201); // ✅ Response-এ depo লোড করা হলো

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("User creation failed: " . $e->getMessage()); // Error লগ করা
            return response()->json([
                'message' => 'User creation failed. Check application logs for details.', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource (Show User for Edit).
     * GET /api/admin/users/{id}
     */
    public function show(string $id)
    {
        // ✅ roles এবং depo লোড করা হলো
        $user = User::with('roles', 'depo')->findOrFail($id);
        
        // Vue-এর জন্য সহজ ফরম্যাটে রিটার্ন করা
        $role = $user->roles->first();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'depo_id' => $user->depo_id, // ✅ depo_id পাঠানো হলো
            'role' => $role ? $role->slug : 'none',
        ]);
    }

    /**
     * Update the specified resource (Update User).
     * PATCH /api/admin/users/{id}
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        // 1. Validation 
        $request->validate([
            'name' => 'required|string|max:255',
            // unique:users,email,{$id}: নিজের ইমেল ছাড়া বাকিদের সাথে ইউনিক চেক করবে
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in($this->editableRoles)],
            // Password optional
            'password' => 'nullable|string|min:8|confirmed',
            
            // ✅ Depo/Distributor রোলের জন্য depo_id Validation
            'depo_id' => [
                Rule::requiredIf(in_array($request->role, ['depo', 'distributor'])),
                'nullable', 
                'exists:depos,id'
            ],
        ]);
        
        DB::beginTransaction();

        try {
            $data = $request->only('name', 'email', 'depo_id'); // ✅ depo_id যোগ করা হলো

            // Update password only if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // Sync new role (remove old and add new)
            $newRole = Role::where('slug', $request->role)->firstOrFail();
            $user->roles()->sync([$newRole->id]);

            DB::commit();

            return response()->json(['message' => 'User updated successfully'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("User update failed: " . $e->getMessage()); // Error লগ করা
            return response()->json([
                'message' => 'User update failed. Check application logs for details.', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage (Delete User).
     * DELETE /api/admin/users/{id}
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting your own account
        if (auth()->user()->id == $user->id) {
            return response()->json(['message' => 'You cannot delete your own account.'], 403);
        }

        $user->roles()->detach(); 
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}