<?php

namespace App\Http\Controllers\Admin;

use App\Features\Admin\Users\Actions\CreateUserAction;
use App\Features\Admin\Users\Actions\UpdateUserAction;
use App\Features\Admin\Users\DTOs\CreateUserDTO;
use App\Features\Admin\Users\DTOs\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->where('email', '!=', 'admin@test.com')->orderBy('id', 'desc')->get();
        return view('back.admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('back.admin.users.create', compact('roles'));
    }


    public function store(StoreUserRequest $request, CreateUserAction $action)
    {
        $dto = CreateUserDTO::fromArray($request->validated());
        $user = $action->execute($dto);
        return redirect()->route('admin.users.index')->with('success', "کاربر «{$user->name}» با موفقیت ایجاد شد.");
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRole = $user->roles->first()?->name;
        return view('back.admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action)
    {
        $dto = UpdateUserDTO::fromArray($request->validated());
        $user = $action->execute($dto, $user);
        return redirect()->route('admin.users.index')->with('success', "اطلاعات کاربر «{$user->name}» با موفقیت ویرایش شد.");
    }

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
