<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BoardMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = BoardMember::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('email', 'like', '%' . $request->q . '%')
                    ->orWhere('phone', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $members = $query
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        $totalMembers = BoardMember::count();
        $activeMembers = BoardMember::where('is_active', true)->count();

        return view('back.admin.board-members.index', compact(
            'members',
            'totalMembers',
            'activeMembers'
        ));
    }

    public function create()
    {
        return view('back.admin.board-members.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['slug'] = Str::slug($request->name) ?: null;
        $data['roles'] = $this->prepareRoles($request->roles);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('board-members', 'public');
        }

        BoardMember::create($data);

        return redirect()
            ->route('admin.board-members.index')
            ->with('success', 'عضو هیئت مدیره با موفقیت ثبت شد.');
    }

    public function edit(BoardMember $boardMember)
    {
        return view('back.admin.board-members.edit', compact('boardMember'));
    }

    public function update(Request $request, BoardMember $boardMember)
    {
        $data = $this->validateData($request, $boardMember->id);

        $data['slug'] = Str::slug($request->name) ?: $boardMember->slug;
        $data['roles'] = $this->prepareRoles($request->roles);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            if ($boardMember->image && Storage::disk('public')->exists($boardMember->image)) {
                Storage::disk('public')->delete($boardMember->image);
            }

            $data['image'] = $request->file('image')->store('board-members', 'public');
        }

        $boardMember->update($data);

        return redirect()
            ->route('admin.board-members.index')
            ->with('success', 'عضو هیئت مدیره با موفقیت ویرایش شد.');
    }

    public function destroy(BoardMember $boardMember)
    {
        if ($boardMember->image && Storage::disk('public')->exists($boardMember->image)) {
            Storage::disk('public')->delete($boardMember->image);
        }

        $boardMember->delete();

        return redirect()
            ->route('admin.board-members.index')
            ->with('success', 'عضو هیئت مدیره با موفقیت حذف شد.');
    }

    private function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'roles' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'fax' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function prepareRoles(?string $roles): array
    {
        if (!$roles) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $roles))
            ->map(fn ($role) => trim($role))
            ->filter()
            ->values()
            ->toArray();
    }
}
