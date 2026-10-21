@extends('front.user.layouts.app')

@section('title', 'ویرایش اطلاعات شرکت')

@section('page_title', 'ویرایش اطلاعات شرکت')

@section('page_description')
    تمامی اطلاعات ثبت‌شده شرکت خود را مشاهده و ویرایش کنید.
@endsection

@include('front.user.company.partials.styles')

@section('content')

    <div class="company-edit-page">

        <div class="company-edit-card">

            @include('front.user.company.partials.header')

            <div class="company-edit-body">

                @include('front.user.company.partials.alerts')

                <form
                        action="{{ route('user.company.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    @include('front.user.company.partials.files')
                    @include('front.user.company.partials.general')
                    @include('front.user.company.partials.registration')
                    @include('front.user.company.partials.contact')
                    @include('front.user.company.partials.additional')
                    @include('front.user.company.partials.ceo')
                    @include('front.user.company.partials.chairman')
                    @include('front.user.company.partials.association-contact')
                    @include('front.user.company.partials.membership')
                    @include('front.user.company.partials.commercial')
                    @include('front.user.company.partials.activities')
                    @include('front.user.company.partials.activity-fields')
                    @include('front.user.company.partials.shareholders')
                    @include('front.user.company.partials.projects')
                    @include('front.user.company.partials.footer-actions')

                </form>

            </div>

        </div>

    </div>

@endsection
