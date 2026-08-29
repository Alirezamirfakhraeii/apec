@php
    $user = auth()->user();

    $displayName = $user?->name ?: 'کاربر عزیز';
    $email = $user?->email ?: 'ثبت نشده';
    $mobile = $user?->mobile ?: 'ثبت نشده';

    $initials = collect(preg_split('/\s+/', trim($displayName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->implode('');
@endphp

<section class="user-profile-card">

    <div class="user-profile-card__cover"></div>


    <div class="user-profile-card__body">

        <div class="user-profile-card__header">

            <div class="user-profile-card__identity">

                <div class="user-profile-card__avatar">
                    {{ $initials ?: 'U' }}
                </div>


                <div class="user-profile-card__name">

                    <h2>
                        {{ $displayName }}
                    </h2>

                    <p>
                        {{ $email }}
                    </p>

                </div>

            </div>


            <div class="user-profile-card__status">
                حساب کاربری فعال
            </div>

        </div>


        <div class="user-profile-card__info-grid">

            <div class="user-profile-card__info-item">
                <span>نام و نام خانوادگی</span>
                <strong>{{ $displayName }}</strong>
            </div>


            <div class="user-profile-card__info-item">
                <span>ایمیل</span>
                <strong dir="ltr">{{ $email }}</strong>
            </div>


            <div class="user-profile-card__info-item">
                <span>شماره همراه</span>
                <strong dir="ltr">{{ $mobile }}</strong>
            </div>

        </div>

    </div>

</section>
