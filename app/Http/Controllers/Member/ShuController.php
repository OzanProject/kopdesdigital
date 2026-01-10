<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ShuMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShuController extends Controller
{
    public function index()
    {
        $nasabah_id = Auth::user()->nasabah->id;
        $shu_members = ShuMember::where('nasabah_id', $nasabah_id)
                                ->whereHas('shu', function($q) {
                                    $q->where('status', 'published');
                                })
                                ->with('shu')
                                ->latest('id')
                                ->paginate(10);
                                
        return view('member.shu.index', compact('shu_members'));
    }
}
