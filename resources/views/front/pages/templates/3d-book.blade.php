@extends('front.layouts.master')

@section('title', $page->title)

@php
    /*
    |--------------------------------------------------------------------------
    | فایل PDF انتخاب‌شده
    |--------------------------------------------------------------------------
    */

    $mediaId = data_get(
        $page->template_data,
        'book_pdf_media_id'
    );

    $bookMedia = $mediaId
        ? \App\Models\Media::find($mediaId)
        : null;

    $pdfUrl = null;
    $fileName = null;

    if ($bookMedia) {
        $pdfUrl = route(
            'media.pdf',
            [
                'id' => $bookMedia->id
            ],
            false
        );

        $fileName = basename($bookMedia->path);
    }
@endphp


@push('styles')
    <style>

        /*
        |--------------------------------------------------------------------------
        | صفحه اصلی
        |--------------------------------------------------------------------------
        */

        .digital-book-page {
            position: relative;
            min-height: 100vh;
            padding: 55px 0 75px;
            overflow: hidden;

            background:
                radial-gradient(
                    circle at 15% 20%,
                    rgba(172, 140, 80, 0.10),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 85% 80%,
                    rgba(49, 85, 166, 0.08),
                    transparent 30%
                ),
                linear-gradient(
                    180deg,
                    #f8f6f1 0%,
                    #ede9e1 100%
                );
        }


        /*
        |--------------------------------------------------------------------------
        | خطوط تزئینی پس‌زمینه
        |--------------------------------------------------------------------------
        */

        .digital-book-page::before,
        .digital-book-page::after {
            position: absolute;
            content: "";
            pointer-events: none;
            border: 1px solid rgba(122, 92, 45, 0.10);
            border-radius: 50%;
        }

        .digital-book-page::before {
            top: -250px;
            right: -250px;
            width: 600px;
            height: 600px;
        }

        .digital-book-page::after {
            bottom: -300px;
            left: -300px;
            width: 700px;
            height: 700px;
        }


        /*
        |--------------------------------------------------------------------------
        | کانتینر
        |--------------------------------------------------------------------------
        */

        .digital-book-container {
            position: relative;
            z-index: 2;
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 30px;
        }


        /*
        |--------------------------------------------------------------------------
        | هدر کتاب
        |--------------------------------------------------------------------------
        */

        .book-hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;

            margin-bottom: 28px;
            padding: 30px 34px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255, 255, 255, 0.96),
                    rgba(248, 244, 235, 0.96)
                );

            border: 1px solid rgba(153, 124, 75, 0.20);
            border-radius: 24px;

            box-shadow:
                0 20px 60px rgba(69, 54, 32, 0.08);
        }

        .book-hero::before {
            position: absolute;
            top: 16px;
            right: 16px;
            bottom: 16px;
            width: 4px;
            content: "";
            background:
                linear-gradient(
                    180deg,
                    #caa96c,
                    #8f6a35
                );
            border-radius: 50px;
        }


        /*
        |--------------------------------------------------------------------------
        | عنوان
        |--------------------------------------------------------------------------
        */

        .book-heading {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .book-heading-icon {
            display: flex;
            flex: 0 0 74px;
            align-items: center;
            justify-content: center;

            width: 74px;
            height: 74px;

            color: #8a6737;
            font-size: 31px;

            background:
                linear-gradient(
                    145deg,
                    #fffaf0,
                    #efe3cc
                );

            border: 1px solid #e2cfad;
            border-radius: 20px;

            box-shadow:
                inset 0 1px 0 #ffffff,
                0 10px 25px rgba(120, 88, 42, 0.12);
        }

        .book-heading-content {
            min-width: 0;
        }

        .book-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 8px;
            padding: 5px 12px;

            color: #8a6737;
            font-size: 11px;
            font-weight: 800;

            background: #f3e8d5;
            border-radius: 30px;
        }

        .book-heading h1 {
            margin: 0;
            color: #25221d;
            font-size: 30px;
            font-weight: 900;
            line-height: 1.5;
        }

        .book-heading p {
            max-width: 800px;
            margin: 8px 0 0;

            color: #716b61;
            font-size: 13px;
            line-height: 2;
        }


        /*
        |--------------------------------------------------------------------------
        | دکمه‌ها
        |--------------------------------------------------------------------------
        */

        .book-actions {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            gap: 10px;
        }

        .book-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            min-height: 44px;
            padding: 9px 17px;

            color: #3f382e;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;

            background: #ffffff;
            border: 1px solid #d9c8aa;
            border-radius: 12px;

            cursor: pointer;

            transition:
                all 0.2s ease;
        }

        .book-action:hover {
            color: #6f5026;
            text-decoration: none;
            background: #fffaf1;
            transform: translateY(-1px);
        }

        .book-action-primary {
            color: #ffffff;
            background:
                linear-gradient(
                    135deg,
                    #8d6938,
                    #b38a50
                );
            border-color: transparent;

            box-shadow:
                0 8px 22px rgba(137, 99, 48, 0.20);
        }

        .book-action-primary:hover {
            color: #ffffff;
            background:
                linear-gradient(
                    135deg,
                    #78572d,
                    #9f7843
                );
        }


        /*
        |--------------------------------------------------------------------------
        | قاب اصلی کتاب
        |--------------------------------------------------------------------------
        */

        .book-library {
            position: relative;

            padding:
                18px 18px 22px;

            background:
                linear-gradient(
                    145deg,
                    #3f3022 0%,
                    #261e17 50%,
                    #17130f 100%
                );

            border:
                1px solid
                rgba(219, 184, 124, 0.45);

            border-radius: 26px;

            box-shadow:
                0 35px 90px rgba(37, 27, 18, 0.30),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        .book-library::before {
            position: absolute;
            top: 7px;
            right: 35px;
            left: 35px;
            height: 1px;
            content: "";

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(221, 186, 124, 0.7),
                    transparent
                );
        }


        /*
        |--------------------------------------------------------------------------
        | نوار بالای Viewer
        |--------------------------------------------------------------------------
        */

        .book-library-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            padding:
                4px 8px 16px;

            color: #d9c5a5;
        }

        .book-library-title {
            display: flex;
            align-items: center;
            gap: 10px;

            font-size: 12px;
            font-weight: 700;
        }

        .book-library-title span:first-child {
            width: 8px;
            height: 8px;
            background: #c79a58;
            border-radius: 50%;

            box-shadow:
                0 0 0 5px rgba(199, 154, 88, 0.12);
        }

        .book-file-name {
            max-width: 420px;
            overflow: hidden;

            color: #9f8d73;
            font-size: 10px;
            white-space: nowrap;
            text-overflow: ellipsis;
        }


        /*
        |--------------------------------------------------------------------------
        | Viewer
        |--------------------------------------------------------------------------
        */

        .book-viewer-frame {
            position: relative;
            width: 100%;
            height: 800px;
            min-height: 620px;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at center,
                    #4b4b4b 0%,
                    #292929 55%,
                    #171717 100%
                );

            border:
                1px solid
                rgba(255, 255, 255, 0.08);

            border-radius: 18px;

            box-shadow:
                inset 0 0 80px rgba(0, 0, 0, 0.38);
        }

        #book-viewer {
            position: relative;
            width: 100%;
            height: 100%;
        }


        /*
        |--------------------------------------------------------------------------
        | راهنما پایین
        |--------------------------------------------------------------------------
        */

        .book-footer-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;

            margin-top: 14px;
            padding: 0 8px;

            color: #9d8c75;
            font-size: 10px;
        }

        .book-footer-hint {
            display: flex;
            align-items: center;
            gap: 7px;
        }


        /*
        |--------------------------------------------------------------------------
        | حالت خطا
        |--------------------------------------------------------------------------
        */

        .book-empty {
            padding: 70px 30px;
            text-align: center;

            background: #ffffff;

            border:
                1px solid
                rgba(161, 131, 83, 0.20);

            border-radius: 20px;

            box-shadow:
                0 20px 50px rgba(76, 58, 31, 0.08);
        }

        .book-empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 85px;
            height: 85px;

            margin: 0 auto 20px;

            color: #9d7844;
            font-size: 34px;

            background: #f6edde;
            border-radius: 24px;
        }

        .book-empty strong {
            display: block;
            margin-bottom: 8px;

            color: #2f2a24;
            font-size: 17px;
        }

        .book-empty span {
            color: #81786c;
            font-size: 12px;
        }


        /*
        |--------------------------------------------------------------------------
        | Fullscreen
        |--------------------------------------------------------------------------
        */

        .book-library:fullscreen {
            width: 100%;
            height: 100vh;
            padding: 15px;
            border-radius: 0;
        }

        .book-library:fullscreen .book-viewer-frame {
            height: calc(100vh - 95px);
            min-height: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991px) {

            .book-hero {
                align-items: flex-start;
                flex-direction: column;
            }

            .book-actions {
                width: 100%;
            }

            .book-action {
                flex: 1;
            }

            .book-viewer-frame {
                height: 700px;
            }
        }


        @media (max-width: 767px) {

            .digital-book-page {
                padding:
                    22px 0 40px;
            }

            .digital-book-container {
                padding:
                    0 12px;
            }

            .book-hero {
                padding:
                    20px 18px;

                border-radius: 18px;
            }

            .book-heading {
                align-items: flex-start;
            }

            .book-heading-icon {
                flex-basis: 55px;
                width: 55px;
                height: 55px;

                font-size: 23px;
                border-radius: 15px;
            }

            .book-heading h1 {
                font-size: 21px;
            }

            .book-heading p {
                font-size: 12px;
            }

            .book-actions {
                flex-direction: column;
            }

            .book-action {
                width: 100%;
            }

            .book-library {
                padding:
                    12px;

                border-radius: 18px;
            }

            .book-library-top {
                align-items: flex-start;
                flex-direction: column;
                gap: 6px;
            }

            .book-viewer-frame {
                height: 620px;
                min-height: 500px;

                border-radius: 12px;
            }

            .book-footer-bar {
                align-items: flex-start;
                flex-direction: column;
            }

        }

    </style>
@endpush


@section('content')

    <section class="digital-book-page">

        <div class="digital-book-container">


            {{-- هدر --}}
            <div class="book-hero">

                <div class="book-heading">

                    <div class="book-heading-icon">
                        <i class="fa fa-book"></i>
                    </div>

                    <div class="book-heading-content">

                        <span class="book-label">
                            کتاب دیجیتال
                        </span>

                        <h1>
                            {{ $page->title }}
                        </h1>

                        @if($page->summary)
                            <p>
                                {{ $page->summary }}
                            </p>
                        @endif

                    </div>

                </div>


                @if($pdfUrl)

                    <div class="book-actions">

                        <a
                            href="{{ $pdfUrl }}"
                            target="_blank"
                            class="book-action"
                        >
                            <i class="fa fa-file-pdf-o"></i>

                            مشاهده PDF
                        </a>

                        <button
                            type="button"
                            class="book-action book-action-primary"
                            id="book-fullscreen-button"
                        >
                            <i class="fa fa-expand"></i>

                            تمام صفحه
                        </button>

                    </div>

                @endif

            </div>


            @if($pdfUrl)

                {{-- قاب اصلی کتاب --}}
                <div
                    class="book-library"
                    id="book-library"
                >

                    {{-- بالای Viewer --}}
                    <div class="book-library-top">

                        <div class="book-library-title">

                            <span></span>

                            <span>
                                نمایش سه‌بعدی محتوا
                            </span>

                        </div>

                        @if($fileName)
                            <div class="book-file-name">
                                {{ $fileName }}
                            </div>
                        @endif

                    </div>


                    {{-- FlipBook --}}
                    <div class="book-viewer-frame">

                        <div id="book-viewer"></div>

                    </div>


                    {{-- پایین Viewer --}}
                    <div class="book-footer-bar">

                        <div class="book-footer-hint">
                            <i class="fa fa-hand-pointer-o"></i>

                            برای ورق زدن، صفحه کتاب را بکشید.
                        </div>

                        <div>
                            {{ $page->title }}
                        </div>

                    </div>

                </div>

            @else

                <div class="book-empty">

                    <div class="book-empty-icon">
                        <i class="fa fa-book"></i>
                    </div>

                    <strong>
                        فایل کتاب انتخاب نشده است
                    </strong>

                    <span>
                        برای این صفحه یک فایل PDF از بخش رسانه‌ها انتخاب کنید.
                    </span>

                </div>

            @endif

        </div>

    </section>

@endsection


@if($pdfUrl)

    @push('scripts')

        {{-- jQuery --}}
        <script
            src="{{ asset('front/vendor/flip-book/js/jquery.min.js') }}">
        </script>

        {{-- html2canvas --}}
        <script
            src="{{ asset('front/vendor/flip-book/js/html2canvas.min.js') }}">
        </script>

        {{-- Three.js --}}
        <script
            src="{{ asset('front/vendor/flip-book/js/three.min.js') }}">
        </script>

        {{-- PDF.js --}}
        <script
            src="{{ asset('front/vendor/flip-book/js/pdf.min.js') }}">
        </script>


        {{-- PDF Worker --}}
        <script>
            window.PDFJS_LOCALE = {
                pdfJsWorker:
                @json(
                    asset(
                        'front/vendor/flip-book/js/pdf.worker.js'
                    )
                )
            };
        </script>


        {{-- FlipBook --}}
        <script
            src="{{ asset('front/vendor/flip-book/dist/flip-book.min.js') }}">
        </script>


        <script>
            document.addEventListener(
                'DOMContentLoaded',
                function () {

                    const pdfUrl =
                        @json($pdfUrl);

                    const templateHtml =
                        @json(
                            asset(
                                'front/vendor/flip-book/templates/default-book-view.html'
                            )
                        );

                    const templateCss =
                        @json(
                            asset(
                                'front/vendor/flip-book/css/short-black-book-view.css'
                            )
                        );

                    const fontAwesomeCss =
                        @json(
                            asset(
                                'front/vendor/flip-book/css/font-awesome.min.css'
                            )
                        );

                    const templateScript =
                        @json(
                            asset(
                                'front/vendor/flip-book/js/default-book-view.js'
                            )
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | اجرای FlipBook
                    |--------------------------------------------------------------------------
                    */

                    if (
                        typeof window.jQuery !== 'undefined' &&
                        typeof jQuery.fn.FlipBook === 'function'
                    ) {

                        $('#book-viewer').FlipBook({

                            pdf: pdfUrl,

                            template: {

                                html:
                                templateHtml,

                                styles: [
                                    templateCss
                                ],

                                links: [
                                    {
                                        rel:
                                            'stylesheet',

                                        href:
                                        fontAwesomeCss
                                    }
                                ],

                                script:
                                templateScript

                            }

                        });

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Fullscreen
                    |--------------------------------------------------------------------------
                    */

                    const fullscreenButton =
                        document.getElementById(
                            'book-fullscreen-button'
                        );

                    const bookLibrary =
                        document.getElementById(
                            'book-library'
                        );

                    if (
                        fullscreenButton &&
                        bookLibrary
                    ) {

                        fullscreenButton.addEventListener(
                            'click',
                            function () {

                                if (
                                    !document.fullscreenElement
                                ) {

                                    bookLibrary
                                        .requestFullscreen();

                                } else {

                                    document
                                        .exitFullscreen();

                                }

                            }
                        );

                    }

                }
            );
        </script>

    @endpush

@endif
