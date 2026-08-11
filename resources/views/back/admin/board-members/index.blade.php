@extends('back.admin.layouts.master')

@section('content')

    <div class="admin-wrapper">

        {{-- Page Header --}}
        <div class="admin-page-header d-flex align-items-center justify-content-between">

            <div>

                <h4 class="admin-page-title">
                    <i class="fa fa-users ml-2"></i>
                    مدیریت اعضای هیئت مدیره
                </h4>

                <div class="admin-page-subtitle">
                    مشاهده، جستجو، ویرایش و مدیریت اعضای هیئت مدیره سایت
                </div>

            </div>


            <a
                href="{{ route('admin.board-members.create') }}"
                class="btn admin-create-btn"
            >
                <i class="fa fa-plus ml-1"></i>
                افزودن عضو جدید
            </a>

        </div>


        {{-- Success Message --}}
        @if(session('success'))

            <div class="alert alert-success font_13">
                <i class="fa fa-check-circle ml-1"></i>
                {{ session('success') }}
            </div>

        @endif


        {{-- Stats --}}
        <div class="row row-sm">

            <div class="col-xl-4 col-lg-4 col-md-6 col-12">

                <div class="admin-stat-card">

                    <div class="d-flex align-items-center">

                        <div>

                            <div class="admin-stat-title">
                                کل اعضا
                            </div>

                            <h3 class="admin-stat-number">
                                {{ $totalMembers ?? 0 }}
                            </h3>

                        </div>


                        <div class="mr-auto">
                            <i class="fa fa-users text-primary admin-stat-icon"></i>
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-xl-4 col-lg-4 col-md-6 col-12">

                <div class="admin-stat-card">

                    <div class="d-flex align-items-center">

                        <div>

                            <div class="admin-stat-title">
                                اعضای فعال
                            </div>

                            <h3 class="admin-stat-number">
                                {{ $activeMembers ?? 0 }}
                            </h3>

                        </div>


                        <div class="mr-auto">
                            <i class="fa fa-check-circle text-success admin-stat-icon"></i>
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-xl-4 col-lg-4 col-md-6 col-12">

                <div class="admin-stat-card">

                    <div class="d-flex align-items-center">

                        <div>

                            <div class="admin-stat-title">
                                نتایج این صفحه
                            </div>

                            <h3 class="admin-stat-number">
                                {{ $members->count() }}
                            </h3>

                        </div>


                        <div class="mr-auto">
                            <i class="fa fa-list text-info admin-stat-icon"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Filters --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-filter ml-2"></i>
                    جستجو و فیلتر اعضا
                </h4>

            </div>


            <div class="admin-card-body">

                <form
                    method="GET"
                    action="{{ route('admin.board-members.index') }}"
                >

                    <div class="row row-sm align-items-end">

                        {{-- Search --}}
                        <div class="col-xl-6 col-lg-6 col-md-12">

                            <div class="form-group mb-lg-0">

                                <label
                                    for="q"
                                    class="admin-label"
                                >
                                    عبارت جستجو
                                </label>


                                <input
                                    type="text"
                                    name="q"
                                    id="q"
                                    value="{{ request('q') }}"
                                    class="form-control admin-form-control"
                                    placeholder="نام، ایمیل یا شماره تماس"
                                >

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="col-xl-3 col-lg-3 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label
                                    for="status"
                                    class="admin-label"
                                >
                                    وضعیت
                                </label>


                                <select
                                    name="status"
                                    id="status"
                                    class="form-control admin-form-control"
                                >

                                    <option value="">
                                        همه وضعیت‌ها
                                    </option>

                                    <option
                                        value="active"
                                        {{ request('status') === 'active' ? 'selected' : '' }}
                                    >
                                        فعال
                                    </option>

                                    <option
                                        value="inactive"
                                        {{ request('status') === 'inactive' ? 'selected' : '' }}
                                    >
                                        غیرفعال
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Submit --}}
                        <div class="col-xl-3 col-lg-3 col-md-6">

                            <button
                                type="submit"
                                class="btn admin-submit-btn"
                            >
                                <i class="fa fa-search ml-1"></i>
                                اعمال فیلتر
                            </button>

                        </div>

                    </div>


                    @if(request()->hasAny(['q', 'status']))

                        <div class="mt-3">

                            <a
                                href="{{ route('admin.board-members.index') }}"
                                class="btn admin-back-btn"
                            >
                                حذف فیلترها
                            </a>

                        </div>

                    @endif

                </form>

            </div>

        </div>


        {{-- Members List --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-table ml-2"></i>
                    لیست اعضای ثبت‌شده
                </h4>

            </div>


            <div class="admin-card-body p-0">

                <div class="table-responsive">

                    <table class="table table-striped table-hover mb-0 font_13">

                        <thead>

                        <tr>

                            <th class="pr-3">
                                تصویر
                            </th>

                            <th>
                                نام عضو
                            </th>

                            <th>
                                سمت‌ها
                            </th>

                            <th>
                                اطلاعات تماس
                            </th>

                            <th>
                                وضعیت
                            </th>

                            <th>
                                ترتیب
                            </th>

                            <th class="text-left pl-3">
                                عملیات
                            </th>

                        </tr>

                        </thead>


                        <tbody>

                        @forelse($members as $member)

                            <tr>

                                {{-- Image --}}
                                <td class="pr-3 align-middle">

                                    @if($member->image)

                                        <img
                                            src="{{ asset('storage/' . $member->image) }}"
                                            alt="{{ $member->name }}"
                                            class="admin-thumb"
                                        >

                                    @else

                                        <div class="admin-empty-thumb">
                                            <i class="fa fa-user"></i>
                                        </div>

                                    @endif

                                </td>


                                {{-- Member --}}
                                <td class="align-middle">

                                    <strong class="d-block text-dark">
                                        {{ $member->name }}
                                    </strong>


                                    @if($member->email)

                                        <span class="text-muted font_12">
                                            {{ $member->email }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Roles --}}
                                <td class="align-middle">

                                    @if(!empty($member->roles))

                                        <ul class="list-unstyled pr-0 mb-0 admin-role-list">

                                            @foreach($member->roles as $role)

                                                <li>

                                                    <i class="fa fa-circle text-primary ml-1 admin-role-dot"></i>

                                                    {{ $role }}

                                                </li>

                                            @endforeach

                                        </ul>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- Contact --}}
                                <td class="align-middle">

                                    @if($member->phone)

                                        <div class="font_12">

                                            <i class="fa fa-phone text-muted ml-1"></i>

                                            {{ $member->phone }}

                                        </div>

                                    @endif


                                    @if($member->fax)

                                        <div class="font_12 mt-1">

                                            <i class="fa fa-fax text-muted ml-1"></i>

                                            {{ $member->fax }}

                                        </div>

                                    @endif


                                    @if(!$member->phone && !$member->fax)

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="align-middle">

                                    @if($member->is_active)

                                        <span class="admin-status active">
                                            فعال
                                        </span>

                                    @else

                                        <span class="admin-status inactive">
                                            غیرفعال
                                        </span>

                                    @endif

                                </td>


                                {{-- Sort --}}
                                <td class="align-middle">

                                    <span class="badge badge-light">
                                        {{ $member->sort_order }}
                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="text-left pl-3 align-middle">

                                    <a
                                        href="{{ route('admin.board-members.edit', $member) }}"
                                        class="admin-action-btn edit"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>


                                    <form
                                        action="{{ route('admin.board-members.destroy', $member) }}"
                                        method="POST"
                                        class="d-inline-block"
                                        onsubmit="return confirm('آیا از حذف این عضو مطمئن هستید؟')"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="admin-action-btn delete"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted py-4 font_13"
                                >
                                    هنوز هیچ عضوی برای هیئت مدیره ثبت نشده است.
                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Pagination --}}
            @if($members->hasPages())

                <div class="card-footer">

                    <div class="d-flex justify-content-center">
                        {{ $members->links() }}
                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection
