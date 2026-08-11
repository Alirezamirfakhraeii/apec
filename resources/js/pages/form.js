document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Conditional Fields
    |--------------------------------------------------------------------------
    */

    const conditionalFields = document.querySelectorAll(
        '[data-condition-field]'
    );


    function getControllerValue(fieldKey) {

        const controller = document.querySelector(
            '[data-template-key="' + fieldKey + '"]'
        );

        if (!controller) {
            return null;
        }

        if (controller.type === 'checkbox') {
            return controller.checked ? '1' : '0';
        }

        return controller.value;
    }


    function updateSubgroupCards() {

        document
            .querySelectorAll('.js-subgroup-card')
            .forEach(function (card) {

                const fields = card.querySelectorAll(
                    '.template-field-item'
                );

                const hasVisibleField = Array
                    .from(fields)
                    .some(function (field) {
                        return !field.classList.contains('d-none');
                    });

                card.classList.toggle(
                    'd-none',
                    !hasVisibleField
                );

            });
    }


    function updateConditionalFields() {

        conditionalFields.forEach(function (wrapper) {

            const fieldKey =
                wrapper.dataset.conditionField;

            const requiredValue =
                wrapper.dataset.conditionValue;

            const currentValue =
                getControllerValue(fieldKey);

            const visible =
                String(currentValue) === String(requiredValue);

            wrapper.classList.toggle(
                'd-none',
                !visible
            );

        });


        updateSubgroupCards();
    }


    document
        .querySelectorAll('.js-template-controller')
        .forEach(function (controller) {

            controller.addEventListener(
                'change',
                updateConditionalFields
            );

        });


    updateConditionalFields();


    /*
    |--------------------------------------------------------------------------
    | 3D Book PDF Field
    |--------------------------------------------------------------------------
    */

    const templateSelect =
        document.getElementById('page-template');

    const bookMediaWrapper =
        document.getElementById('3d-book-media-wrapper');


    function toggle3dBookMedia() {

        if (!templateSelect || !bookMediaWrapper) {
            return;
        }

        bookMediaWrapper.classList.toggle(
            'd-none',
            templateSelect.value !== '3d-book'
        );
    }


    if (templateSelect) {

        templateSelect.addEventListener(
            'change',
            toggle3dBookMedia
        );

        toggle3dBookMedia();
    }


    /*
    |--------------------------------------------------------------------------
    | CKEditor
    |--------------------------------------------------------------------------
    */

    const bodyElement =
        document.getElementById('page-body');


    if (
        !bodyElement ||
        typeof ClassicEditor === 'undefined'
    ) {
        return;
    }


    const uploadUrl =
        bodyElement.dataset.uploadUrl;


    ClassicEditor
        .create(bodyElement, {

            ckfinder: {
                uploadUrl: uploadUrl
            },

            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'blockQuote',
                    'insertTable',
                    'uploadImage',
                    '|',
                    'undo',
                    'redo'
                ],

                shouldNotGroupWhenFull: true
            },

            language: 'fa'

        })
        .then(function (editor) {

            /*
            |--------------------------------------------------------------------------
            | Disable Sticky Toolbar
            |--------------------------------------------------------------------------
            */

            const stickyPanel =
                editor.ui.view.stickyPanel;


            if (stickyPanel) {

                if (
                    typeof stickyPanel.unbind === 'function'
                ) {
                    stickyPanel.unbind('isActive');
                }

                stickyPanel.isActive = false;
            }


            /*
            |--------------------------------------------------------------------------
            | Editor Focus Fix
            |--------------------------------------------------------------------------
            */

            const editableElement =
                editor.ui.getEditableElement();


            function editorHasFocus() {

                if (!editableElement) {
                    return false;
                }

                return (
                    document.activeElement === editableElement ||
                    editableElement.contains(
                        document.activeElement
                    )
                );
            }


            function releaseEditorFocus() {

                if (
                    !editableElement ||
                    !editorHasFocus()
                ) {
                    return;
                }

                editableElement.blur();


                requestAnimationFrame(function () {
                    editableElement.blur();
                });
            }


            window.addEventListener(
                'wheel',
                releaseEditorFocus,
                {
                    capture: true,
                    passive: true
                }
            );


            window.addEventListener(
                'touchmove',
                releaseEditorFocus,
                {
                    capture: true,
                    passive: true
                }
            );


            let previousScrollY =
                window.scrollY;


            window.addEventListener(
                'scroll',
                function () {

                    const currentScrollY =
                        window.scrollY;


                    if (
                        currentScrollY !== previousScrollY &&
                        editorHasFocus()
                    ) {
                        releaseEditorFocus();
                    }


                    previousScrollY =
                        currentScrollY;

                },
                {
                    passive: true
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Sync Editor Before Submit
            |--------------------------------------------------------------------------
            */

            const form =
                bodyElement.closest('form');


            if (form) {

                form.addEventListener(
                    'submit',
                    function () {

                        bodyElement.value =
                            editor.getData();

                    }
                );

            }


            window.pageBodyEditor =
                editor;

        })
        .catch(function (error) {

            console.error(
                'CKEditor Error:',
                error
            );

        });

});
