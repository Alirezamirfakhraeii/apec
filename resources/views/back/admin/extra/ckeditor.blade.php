@once
    @push('styles')
        <style>
            .ck-editor__editable {
                min-height: 350px;
                direction: rtl;
                text-align: right;
                line-height: 2;
            }

            .ck-content {
                font-size: 14px;
            }

            .ck-content p {
                margin-bottom: 12px;
            }

            .ck-content img {
                max-width: 100%;
                height: auto;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

        <script>
            class LaravelUploadAdapter {
                constructor(loader) {
                    this.loader = loader;
                }

                upload() {
                    return this.loader.file.then(file => new Promise((resolve, reject) => {
                        const data = new FormData();

                        data.append('upload', file);

                        fetch("{{ route('admin.ckeditor.upload') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: data
                        })
                            .then(response => response.json())
                            .then(result => {
                                if (!result.url) {
                                    reject(result.message || 'Upload failed');
                                    return;
                                }

                                resolve({
                                    default: result.url
                                });
                            })
                            .catch(error => {
                                reject(error);
                            });
                    }));
                }

                abort() {
                    //
                }
            }

            function LaravelUploadAdapterPlugin(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                    return new LaravelUploadAdapter(loader);
                };
            }

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.js-ckeditor').forEach(function (element) {
                    if (element.dataset.ckeditorInitialized === 'true') {
                        return;
                    }

                    element.dataset.ckeditorInitialized = 'true';

                    ClassicEditor
                        .create(element, {
                            language: 'fa',
                            extraPlugins: [
                                LaravelUploadAdapterPlugin
                            ],
                            toolbar: [
                                'heading',
                                '|',
                                'bold',
                                'italic',
                                'link',
                                'bulletedList',
                                'numberedList',
                                'blockQuote',
                                '|',
                                'imageUpload',
                                'insertTable',
                                '|',
                                'undo',
                                'redo'
                            ],
                            image: {
                                toolbar: [
                                    'imageTextAlternative',
                                    'imageStyle:inline',
                                    'imageStyle:block',
                                    'imageStyle:side'
                                ]
                            },
                            heading: {
                                options: [
                                    {
                                        model: 'paragraph',
                                        title: 'متن معمولی',
                                        class: 'ck-heading_paragraph'
                                    },
                                    {
                                        model: 'heading2',
                                        view: 'h2',
                                        title: 'تیتر اصلی بخش',
                                        class: 'ck-heading_heading2'
                                    },
                                    {
                                        model: 'heading3',
                                        view: 'h3',
                                        title: 'زیر تیتر',
                                        class: 'ck-heading_heading3'
                                    }
                                ]
                            }
                        })
                        .then(function (editor) {
                            editor.editing.view.change(function (writer) {
                                writer.setAttribute(
                                    'dir',
                                    'rtl',
                                    editor.editing.view.document.getRoot()
                                );

                                writer.setStyle(
                                    'text-align',
                                    'right',
                                    editor.editing.view.document.getRoot()
                                );
                            });

                            console.log('CKEditor فعال شد:', element.name);
                        })
                        .catch(function (error) {
                            console.error('خطای CKEditor:', error);
                        });
                });
            });
        </script>
    @endpush
@endonce
