<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')
            ->where('email', '!=', 'admin@test.com')
            ->orderBy('id', 'desc')
            ->get();

        return view('back.admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('back.admin.users.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'nullable|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->filled('role')) {
            $user->assignRole($request->role);
        }

        return redirect()->route('admin.users.index')->with('success', "کاربر «{$user->name}» با موفقیت ایجاد شد.");
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        // گرفتن نام نقش فعلی کاربر
        $userRole = $user->roles->first()?->name;

        return view('back.admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|exists:roles,name',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // امنیت نقش خود ادمین اصلی
        if ($user->id === auth()->id() && $user->hasRole('Super Auth') && $request->role !== 'Super Auth') {
            return redirect()->back()->with('error', 'شما نمی‌توانید نقش خودتان را تغییر دهید!');
        }

        if ($request->filled('role')) {
            $user->syncRoles([$request->role]);
        } else {
            $user->syncRoles([]);
        }

        return redirect()->route('admin.users.index')->with('success', "اطلاعات کاربر «{$user->name}» با موفقیت ویرایش شد.");
    }

    // ۶. عملیات حذف کاربر
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'شما نمی‌توانید حساب کاربری خودتان را حذف کنید!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'کاربر مورد نظر با موفقیت حذف شد.');
    }






    public function update_role(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        if ($user->id === auth()->id() && $user->hasRole('Super Auth') && $request->role !== 'Super Auth') {
            return redirect()->back()->with('error', 'شما نمی‌توانید نقش Super Auth خود را تغییر دهید!');
        }
        $user->syncRoles([$request->role]);
        return redirect()->back()->with('success', "نقش کاربر «{$user->name}» با موفقیت به «{$request->role}» تغییر یافت.");
    }

    public function remove_role(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'شما نمی‌توانید نقش خودتان را حذف کنید!');
        }
        $user->syncRoles([]);
        return redirect()->back()->with('success', "تمام نقش‌های کاربر «{$user->name}» حذف شد و به کاربر عادی تبدیل شد.");
    }

}
