@extends('front.layouts.master')

@section('title', 'ارسال فایل')

@section('content')

    <div class="container py-5" dir="rtl">

        <div class="upload-page">

            <div class="upload-card">

                <div class="upload-card__header">

                    <div class="upload-card__icon">
                        <i class="fa fa-cloud-upload-alt"></i>
                    </div>

                    <div>
                        <h1>
                            ارسال فایل
                        </h1>

                        <p>
                            فایل موردنظر خود را انتخاب یا داخل کادر رها کنید.
                            حداکثر حجم مجاز فایل ۵ مگابایت است.
                        </p>
                    </div>

                </div>


                @if(session('success'))

                    <div class="upload-alert upload-alert--success">

                        <i class="fa fa-check-circle"></i>

                        <span>
                        {{ session('success') }}
                    </span>

                    </div>

                @endif


                @error('file')

                <div class="upload-alert upload-alert--danger">

                    <i class="fa fa-exclamation-circle"></i>

                    <span>
                        {{ $message }}
                    </span>

                </div>

                @enderror


                <form
                    action="{{ route('upload.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="uploadForm"
                >

                    @csrf

                    <div
                        class="upload-dropzone"
                        id="uploadDropzone"
                    >

                        <input
                            type="file"
                            name="file"
                            id="fileInput"
                            required
                            hidden
                        >


                        <div class="upload-dropzone__content">

                            <div class="upload-dropzone__icon">
                                <i class="fa fa-file-upload"></i>
                            </div>


                            <h2>
                                فایل را اینجا رها کنید
                            </h2>


                            <p>
                                یا برای انتخاب فایل کلیک کنید
                            </p>


                            <button
                                type="button"
                                class="upload-select-btn"
                                id="selectFileBtn"
                            >
                                انتخاب فایل
                            </button>


                            <span class="upload-dropzone__hint">
                            حداکثر حجم مجاز: ۵ مگابایت
                        </span>

                        </div>

                    </div>


                    <div
                        class="upload-selected-file"
                        id="selectedFile"
                        hidden
                    >

                        <div class="upload-selected-file__icon">
                            <i class="fa fa-file"></i>
                        </div>


                        <div class="upload-selected-file__info">

                            <strong id="selectedFileName">
                                -
                            </strong>

                            <span id="selectedFileSize">
                            -
                        </span>

                        </div>


                        <button
                            type="button"
                            class="upload-remove-btn"
                            id="removeFileBtn"
                            title="حذف فایل"
                        >
                            <i class="fa fa-times"></i>
                        </button>

                    </div>


                    <div class="upload-form__footer">

                        <button
                            type="submit"
                            class="upload-submit-btn"
                            id="submitBtn"
                            disabled
                        >

                            <i class="fa fa-paper-plane"></i>

                            <span>
                            ارسال فایل
                        </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <style>

        .upload-page {
            width: 100%;
            max-width: 760px;
            margin: 0 auto;
        }


        .upload-card {
            overflow: hidden;

            border: 1px solid #e7ebf0;
            border-radius: 20px;

            background: #ffffff;

            box-shadow:
                0 12px 35px rgba(15, 23, 42, .07);
        }


        .upload-card__header {
            padding: 28px;

            display: flex;
            align-items: flex-start;
            gap: 15px;

            border-bottom: 1px solid #edf0f4;
        }


        .upload-card__icon {
            width: 48px;
            height: 48px;

            flex: 0 0 48px;

            display: grid;
            place-items: center;

            border-radius: 14px;

            background: #eef4ff;
            color: #173a70;

            font-size: 20px;
        }


        .upload-card__header h1 {
            margin: 0;

            color: #1f2937;

            font-size: 21px;
            font-weight: 900;
        }


        .upload-card__header p {
            margin: 7px 0 0;

            color: #667085;

            font-size: 13px;
            line-height: 2;
        }


        .upload-alert {
            margin: 20px 25px 0;

            padding: 13px 15px;

            display: flex;
            align-items: center;
            gap: 9px;

            border-radius: 11px;

            font-size: 13px;
            font-weight: 700;
        }


        .upload-alert--success {
            border: 1px solid #bbf7d0;

            background: #ecfdf3;
            color: #15803d;
        }


        .upload-alert--danger {
            border: 1px solid #fecaca;

            background: #fef2f2;
            color: #b42318;
        }


        #uploadForm {
            padding: 25px;
        }


        .upload-dropzone {
            min-height: 270px;

            padding: 30px;

            display: grid;
            place-items: center;

            border: 2px dashed #cbd5e1;
            border-radius: 16px;

            background: #f8fafc;

            cursor: pointer;

            transition: all .2s ease;
        }


        .upload-dropzone:hover {
            border-color: #173a70;

            background: #f5f8ff;
        }


        .upload-dropzone.is-dragging {
            border-color: #2563eb;

            background: #eef4ff;

            transform: scale(1.01);
        }


        .upload-dropzone__content {
            text-align: center;
        }


        .upload-dropzone__icon {
            width: 68px;
            height: 68px;

            margin: 0 auto 15px;

            display: grid;
            place-items: center;

            border-radius: 18px;

            background: #ffffff;

            color: #173a70;

            font-size: 27px;

            box-shadow:
                0 7px 20px rgba(23, 58, 112, .08);
        }


        .upload-dropzone h2 {
            margin: 0;

            color: #344054;

            font-size: 16px;
            font-weight: 900;
        }


        .upload-dropzone p {
            margin: 7px 0 15px;

            color: #98a2b3;

            font-size: 12px;
        }


        .upload-select-btn {
            min-height: 40px;

            padding: 0 17px;

            border: 1px solid #d7dee8;
            border-radius: 10px;

            background: #ffffff;

            color: #344054;

            font-family: inherit;
            font-size: 12px;
            font-weight: 800;

            cursor: pointer;

            transition: .2s ease;
        }


        .upload-select-btn:hover {
            border-color: #173a70;

            color: #173a70;
        }


        .upload-dropzone__hint {
            display: block;

            margin-top: 15px;

            color: #98a2b3;

            font-size: 11px;
        }


        .upload-selected-file {
            margin-top: 16px;

            padding: 14px;

            display: flex;
            align-items: center;
            gap: 12px;

            border: 1px solid #e7ebf0;
            border-radius: 12px;

            background: #ffffff;
        }


        .upload-selected-file__icon {
            width: 42px;
            height: 42px;

            flex: 0 0 42px;

            display: grid;
            place-items: center;

            border-radius: 10px;

            background: #eef4ff;

            color: #173a70;

            font-size: 16px;
        }


        .upload-selected-file__info {
            min-width: 0;
            flex: 1;
        }


        .upload-selected-file__info strong,
        .upload-selected-file__info span {
            display: block;
        }


        .upload-selected-file__info strong {
            overflow: hidden;

            color: #344054;

            font-size: 12px;
            font-weight: 800;

            text-overflow: ellipsis;
            white-space: nowrap;
        }


        .upload-selected-file__info span {
            margin-top: 4px;

            color: #98a2b3;

            font-size: 10px;
        }


        .upload-remove-btn {
            width: 34px;
            height: 34px;

            flex: 0 0 34px;

            display: grid;
            place-items: center;

            border: 1px solid #fecaca;
            border-radius: 9px;

            background: #fff;

            color: #b42318;

            cursor: pointer;

            transition: .2s ease;
        }


        .upload-remove-btn:hover {
            background: #fef2f2;

            border-color: #ef4444;
        }


        .upload-form__footer {
            margin-top: 20px;

            padding-top: 20px;

            display: flex;
            justify-content: flex-end;

            border-top: 1px solid #edf0f4;
        }


        .upload-submit-btn {
            min-width: 135px;
            min-height: 44px;

            padding: 0 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            border: 1px solid #173a70;
            border-radius: 10px;

            background: #173a70;

            color: #ffffff;

            font-family: inherit;
            font-size: 12px;
            font-weight: 800;

            cursor: pointer;

            transition: .2s ease;
        }


        .upload-submit-btn:hover:not(:disabled) {
            background: #12274a;
        }


        .upload-submit-btn:disabled {
            opacity: .45;

            cursor: not-allowed;
        }


        @media (max-width: 600px) {

            .upload-card__header {
                padding: 20px;
            }

            #uploadForm {
                padding: 20px;
            }

            .upload-dropzone {
                min-height: 230px;

                padding: 22px;
            }

            .upload-form__footer {
                justify-content: stretch;
            }

            .upload-submit-btn {
                width: 100%;
            }

        }

    </style>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const dropzone =
                document.getElementById('uploadDropzone');

            const fileInput =
                document.getElementById('fileInput');

            const selectFileBtn =
                document.getElementById('selectFileBtn');

            const selectedFile =
                document.getElementById('selectedFile');

            const selectedFileName =
                document.getElementById('selectedFileName');

            const selectedFileSize =
                document.getElementById('selectedFileSize');

            const removeFileBtn =
                document.getElementById('removeFileBtn');

            const submitBtn =
                document.getElementById('submitBtn');


            const maxFileSize =
                5 * 1024 * 1024;


            function formatFileSize(bytes) {

                if (bytes < 1024) {
                    return bytes + ' B';
                }

                if (bytes < 1024 * 1024) {
                    return (bytes / 1024).toFixed(1) + ' KB';
                }

                return (bytes / 1024 / 1024).toFixed(2) + ' MB';

            }


            function clearFile() {

                fileInput.value = '';

                selectedFile.hidden = true;

                submitBtn.disabled = true;

                selectedFileName.textContent = '-';

                selectedFileSize.textContent = '-';

            }


            function handleFile(file) {

                if (!file) {
                    clearFile();
                    return;
                }


                if (file.size > maxFileSize) {

                    alert(
                        'حجم فایل بیشتر از ۵ مگابایت است.'
                    );

                    clearFile();

                    return;
                }


                selectedFileName.textContent =
                    file.name;

                selectedFileSize.textContent =
                    formatFileSize(file.size);

                selectedFile.hidden = false;

                submitBtn.disabled = false;

            }


            dropzone.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target.closest(
                            '#selectFileBtn'
                        )
                    ) {
                        return;
                    }

                    fileInput.click();

                }
            );


            selectFileBtn.addEventListener(
                'click',
                function () {

                    fileInput.click();

                }
            );


            fileInput.addEventListener(
                'change',
                function () {

                    handleFile(
                        fileInput.files[0]
                    );

                }
            );


            [
                'dragenter',
                'dragover'
            ].forEach(function (eventName) {

                dropzone.addEventListener(
                    eventName,
                    function (event) {

                        event.preventDefault();
                        event.stopPropagation();

                        dropzone.classList.add(
                            'is-dragging'
                        );

                    }
                );

            });


            [
                'dragleave',
                'drop'
            ].forEach(function (eventName) {

                dropzone.addEventListener(
                    eventName,
                    function (event) {

                        event.preventDefault();
                        event.stopPropagation();

                        dropzone.classList.remove(
                            'is-dragging'
                        );

                    }
                );

            });


            dropzone.addEventListener(
                'drop',
                function (event) {

                    const files =
                        event.dataTransfer.files;

                    if (!files.length) {
                        return;
                    }


                    const file =
                        files[0];


                    if (file.size > maxFileSize) {

                        alert(
                            'حجم فایل بیشتر از ۵ مگابایت است.'
                        );

                        clearFile();

                        return;
                    }


                    const dataTransfer =
                        new DataTransfer();

                    dataTransfer.items.add(file);

                    fileInput.files =
                        dataTransfer.files;


                    handleFile(file);

                }
            );


            removeFileBtn.addEventListener(
                'click',
                function () {

                    clearFile();

                }
            );

        });

    </script>

@endsection
