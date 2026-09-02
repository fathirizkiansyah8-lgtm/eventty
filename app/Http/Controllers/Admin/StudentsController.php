<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'student');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('nis', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('class', 'like', "%{$s}%");
            });
        }

        if ($request->filled('class_level')) {
            $query->where('class', 'like', $request->class_level . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->withCount([
            'registeredEvents',
            'certificates',
        ])->orderBy('name')->paginate(15)->withQueryString();

        $totalStudents = User::where('role', 'student')->count();
        $activeStudents = User::where('role', 'student')->where('status', 'active')->count();

        return view('admin.students', compact('students', 'totalStudents', 'activeStudents'));
    }
}
