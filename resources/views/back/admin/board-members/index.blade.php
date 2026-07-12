@extends('back.admin.layouts.master')

@section('content')

    @include('back.admin.board-members.partials.styles')

    <div class="board-member-wrapper">

        <div class="board-member-page-header d-flex align-items-center justify-content-between">
            <div>
                <h4 class="board-member-page-title">
                    <i class="fa fa-users ml-2"></i>
                    مدیریت اعضای هیئت مدیره
                </h4>

                <div class="board-member-page-subtitle">
                    مشاهده، جستجو، ویرایش و مدیریت اعضای هیئت مدیره سایت
                </div>
            </div>

            <a href="{{ route('admin.board-members.create') }}" class="btn board-member-create-btn">
                <i class="fa fa-plus ml-1"></i>
                افزودن عضو جدید
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success font_13">
                <i class="fa fa-check-circle ml-1"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="row row-sm">

            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                <div class="board-member-stat-card">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="board-member-stat-title">کل اعضا</div>
                            <h3 class="board-member-stat-number">{{ $totalMembers ?? 0 }}</h3>
                        </div>

                        <div class="mr-auto">
                            <i class="fa fa-users text-primary" style="font-size: 28px;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                <div class="board-member-stat-card">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="board-member-stat-title">اعضای فعال</div>
                            <h3 class="board-member-stat-number">{{ $activeMembers ?? 0 }}</h3>
                        </div>

                        <div class="mr-auto">
                            <i class="fa fa-check-circle text-success" style="font-size: 28px;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                <div class="board-member-stat-card">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="board-member-stat-title">نتایج این صفحه</div>
                            <h3 class="board-member-stat-number">{{ $members->count() }}</h3>
                        </div>

                        <div class="mr-auto">
                            <i class="fa fa-list text-info" style="font-size: 28px;"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="board-member-card">
            <div class="board-member-card-header">
                <h4 class="board-member-card-title">
                    <i class="fa fa-filter ml-2"></i>
                    جستجو و فیلتر اعضا
                </h4>
            </div>

            <div class="board-member-card-body">
                <form method="GET" action="{{ route('admin.board-members.index') }}">
                    <div class="row row-sm align-items-end">

                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <div class="form-group mb-lg-0">
                                <label for="q" class="board-member-label">
                                    عبارت جستجو
                                </label>

                                <input type="text"
                                       name="q"
                                       id="q"
                                       value="{{ request('q') }}"
                                       class="form-control board-member-form-control"
                                       placeholder="نام، ایمیل یا شماره تماس">
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="form-group mb-lg-0">
                                <label for="status" class="board-member-label">
                                    وضعیت
                                </label>

                                <select name="status" id="status" class="form-control board-member-form-control">
                                    <option value="">همه وضعیت‌ها</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                                        فعال
                                    </option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                        غیرفعال
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <button type="submit" class="btn board-member-submit-btn">
                                <i class="fa fa-search ml-1"></i>
                                اعمال فیلتر
                            </button>
                        </div>

                    </div>

                    @if(request()->hasAny(['q', 'status']))
                        <div class="mt-3">
                            <a href="{{ route('admin.board-members.index') }}" class="btn board-member-back-btn">
                                حذف فیلترها
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="board-member-card">
            <div class="board-member-card-header">
                <h4 class="board-member-card-title">
                    <i class="fa fa-table ml-2"></i>
                    لیست اعضای ثبت‌شده
                </h4>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 font_13">
                        <thead>
                        <tr>
                            <th class="pr-3">تصویر</th>
                            <th>نام عضو</th>
                            <th>سمت‌ها</th>
                            <th>اطلاعات تماس</th>
                            <th>وضعیت</th>
                            <th>ترتیب</th>
                            <th class="text-left pl-3">عملیات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td class="pr-3 align-middle">
                                    @if($member->image)
                                        <img src="{{ asset('storage/' . $member->image) }}"
                                             alt="{{ $member->name }}"
                                             class="board-member-thumb">
                                    @else
                                        <div class="board-member-empty-thumb">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    @endif
                                </td>

                                <td class="align-middle">
                                    <strong class="d-block text-dark">{{ $member->name }}</strong>

                                    @if($member->email)
                                        <span class="text-muted font_12">
                                            {{ $member->email }}
                                        </span>
                                    @endif
                                </td>

                                <td class="align-middle">
                                    @if(!empty($member->roles))
                                        <ul class="list-unstyled pr-0 mb-0" style="line-height: 24px;">
                                            @foreach($member->roles as $role)
                                                <li>
                                                    <i class="fa fa-circle text-primary ml-1" style="font-size: 6px;"></i>
                                                    {{ $role }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

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
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td class="align-middle">
                                    @if($member->is_active)
                                        <span class="board-member-status active">فعال</span>
                                    @else
                                        <span class="board-member-status inactive">غیرفعال</span>
                                    @endif
                                </td>

                                <td class="align-middle">
                                    <span class="badge badge-light">
                                        {{ $member->sort_order }}
                                    </span>
                                </td>

                                <td class="text-left pl-3 align-middle">
                                    <a href="{{ route('admin.board-members.edit', $member) }}"
                                       class="board-member-action-btn edit">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.board-members.destroy', $member) }}"
                                          method="POST"
                                          class="d-inline-block"
                                          onsubmit="return confirm('آیا از حذف این عضو مطمئن هستید؟')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="board-member-action-btn delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4 font_13">
                                    هنوز هیچ عضوی برای هیئت مدیره ثبت نشده است.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

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
