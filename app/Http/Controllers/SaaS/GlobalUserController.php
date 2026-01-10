<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GlobalUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withoutGlobalScope('koperasi')
            ->select('users.*') // Select users columns to avoid ambiguous id
            ->leftJoin('model_has_roles', function($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                     ->where('model_has_roles.model_type', '=', 'App\Models\User');
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->with(['koperasi', 'roles']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%");
            });
        }

        // Sorting Priority:
        // 1. Super Admin
        // 2. Admin Koperasi (Newest First)
        // 3. Others (Newest First)
        $users = $query->orderByRaw("
            CASE 
                WHEN roles.name = 'super_admin' THEN 1 
                WHEN roles.name = 'admin_koperasi' THEN 2 
                ELSE 3 
            END ASC
        ")
        ->orderBy('users.created_at', 'DESC')
        ->paginate(15);

        return view('saas.users.index_global', compact('users'));
    }
}
