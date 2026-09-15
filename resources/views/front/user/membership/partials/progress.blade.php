@php
       $steps = [
           1 => [
               'label' => 'مشخصات شرکت',
               'route' => 'user.membership.basic',
           ],

           2 => [
               'label' => 'ثبت و مالکیت',
               'route' => 'user.membership.registration',
           ],

           3 => [
               'label' => 'سوابق و مدارک',
               'route' => 'user.membership.qualifications',
           ],

           4 => [
               'label' => 'بازبینی و ارسال',
               'route' => 'user.membership.review',
           ],
       ];
@endphp
<div class="membership-progress">
    @foreach($steps as $number => $step)
        <a
            href="{{ $number <= $currentStep ? route($step['route'], $application) : 'javascript:void(0)' }}"
            class="membership-progress__item {{ $number < $currentStep ? 'is-done' : '' }} {{ $number === $currentStep ? 'is-active' : '' }}"
        >
            <span class="membership-progress__number">{{ $number }}</span>
            <span>{{ $step['label'] }}</span>
        </a>
    @endforeach
</div>
