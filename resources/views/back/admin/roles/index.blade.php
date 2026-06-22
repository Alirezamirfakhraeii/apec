@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">تنظیمات سیستم</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ مدیریت نقش‌ها و مجوزها</span>
            </div>
        </div>
    </div>

    <div class="row row-sm">
        @if(session('success'))
            <div class="col-12"><div class="alert alert-success">{{ session('success') }}</div></div>
        @endif
        @if(session('error'))
            <div class="col-12"><div class="alert alert-danger">{{ session('error') }}</div></div>
        @endif

        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header">
                    <h4 class="card-title mb-1">ایجاد نقش (رول) جدید</h4>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="font_13 fw-bold">نام نقش (به انگلیسی یا فارسی) :</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="مثلا: Manager یا نویسنده" value="{{ old('name') }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font_13 fw-bold d-block mb-2">انتخاب مجوزهای دسترسی :</label>
                            <div class="border p-3" style="max-height: 250px; overflow-y: auto; border-radius: 4px; background: #fdfdfd;">
                                @foreach($permissions as $perm)
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="custom-control-input" id="perm-{{ $perm->id }}">
                                        <label class="custom-control-label font_13 text-muted" style="cursor:pointer;" for="perm-{{ $perm->id }}">{{ $perm->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary d-block w-100 mt-4">ثبت نقش جدید</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-1">نقش‌های تعریف شده و دسترسی‌ها</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>نام نقش</th>
                                <th>مجوزهای متصل شده</th>
                                <th width="150">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $role->name }}</td>
                                    <td class="text-right">
                                        @if($role->name === 'Super Auth')
                                            <span class="badge badge-danger">دسترسی کامل به تمام سیستم</span>
                                        @elseif($role->permissions->isEmpty())
                                            <span class="badge badge-light text-muted">بدون مجوز</span>
                                        @else
                                            @foreach($role->permissions as $p)
                                                <span class="badge badge-light border text-secondary m-1">{{ $p->name }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if($role->name !== 'Super Auth')
                                            <button class="btn btn-sm btn-info-light edit-role-btn"
                                                    data-id="{{ $role->id }}"
                                                    data-name="{{ $role->name }}"
                                                    data-perms="{{ json_encode($role->permissions->pluck('id')) }}">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این نقش مطمئن هستید؟ کاربران این نقش، دسترسی‌های خود را از دست خواهند داد.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger-light"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <span class="text-muted font_12">غیرقابل تغییر</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ویرایش نقش و مجوزها</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="editRoleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="fw-bold">نام نقش :</label>
                            <input type="text" name="name" id="edit_role_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold d-block mb-2">اصلاح مجوزهای دسترسی :</label>
                            <div class="border p-3" style="max-height: 250px; overflow-y: auto; border-radius: 4px;">
                                @foreach($permissions as $perm)
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="custom-control-input edit-perm-checkbox" id="edit-perm-{{ $perm->id }}">
                                        <label class="custom-control-label font_13" style="cursor:pointer;" for="edit-perm-{{ $perm->id }}">{{ $perm->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                        <button type="submit" class="btn btn-primary">اعمال تغییرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.edit-role-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const associatedPerms = JSON.parse(this.getAttribute('data-perms')); // آرایه‌ای از ID مجوزها

                    // تصحیح راوت فرم مدال
                    let updateUrl = "{{ route('admin.roles.update', ':id') }}".replace(':id', id);
                    document.getElementById('editRoleForm').setAttribute('action', updateUrl);
                    document.getElementById('edit_role_name').value = name;

                    // ریست و فعال کردن چک‌باکس‌های مربوط به این رول
                    document.querySelectorAll('.edit-perm-checkbox').forEach(checkbox => {
                        checkbox.checked = associatedPerms.includes(parseInt(checkbox.value));
                    });

                    const modal = new bootstrap.Modal(document.getElementById('editRoleModal'));
                    modal.show();
                });
            });
        });
    </script>
@endpush
