<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CKEditor</title>
    {{-- <script src="{{ asset('vendor/ckeditor-full/ckeditor.js') }}"></script> --}}
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>


</head>

<body>
    <div>
        <div id="root">sdfisdii</div>
        <textarea id="editor1"> </textarea>
        <script>
           
            // CKEDITOR.replace( 'ckeditor', { customConfig: '{{ asset('vendor/ckeditor-full/config.js') }}' } );
           
            CKEDITOR.replace('editor1', {
                // Define changes to default configuration here. For example:
                uiColor: '#FFFF00',
                toolbarGroups: [
                    { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
                    { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'] },
                    { name: 'colors' },
                    '/',
                    { name: 'clipboard', groups: ['clipboard', 'undo'] },
                    { name: 'editing', groups: ['find', 'selection', 'spellchecker'] },
                    { name: 'video' },
                    { name: 'links' },
                    { name: 'insert'},
                    { name: 'forms', groups: ['button', 'radio', 'select'] },
                    '/',
                    { name: 'styles' },
                    { name: 'tools' },
                    { name: 'others' },
                    { name: 'document', groups: ['mode', 'document', 'doctools'] },
	            ],
                filebrowserBrowseUrl: `file-manager/ckeditor`,
                filebrowserUploadUrl: `/file-manager/ckeditor/upload`,
                // filebrowserUploadMethod : 'form',
                filebrowserImageBrowseUrl: `/file-manager/ckeditor`,
                filebrowserImageUploadUrl: `/file-manager/ckeditor/upload`,

            });


            // CKEDITOR.editorConfig = function(config) {
            //     // Define changes to default configuration here. For example:
            //     // config.language = 'fr';
            //     config.uiColor = '#FFFF00';
            //     config.extraPlugins = ['video'];
            //     config.removeButtons = 'print, pdf, preview';
            //     config.removePlugins =
            //         'about, forms, print, preview, newpage, save, scayt, exportpdf,find, pastefromdocs, pastefromword, selectall, language';
            //     config.filebrowserImageBrowseUrl = `/file-manager/ckeditor`;
            //     config.filebrowserImageUploadUrl = `/file-manager/upload`;
            //     config.format_tags = 'p;h1;h2;h3;h4;h5;h6;pre';
            //     config.removeDialogTabs = '';
            // };
        </script>
    </div>
</body>

</html>
