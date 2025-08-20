<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | Here you can define the options that are passed to all NovaTinyMCE
    | fields by default.
    |
    */

    'default_options' => [
        'content_css' => '/vendor/tinymce/skins/ui/oxide/content.min.css',
        'skin_url' => '/vendor/tinymce/skins/ui/oxide',
        'content_css_dark' => '/vendor/tinymce/skins/ui/oxide-dark/content.min.css',
        'skin_url_dark' => '/vendor/tinymce/skins/ui/oxide-dark',
        'path_absolute' => '/',
        'plugins' => [
            'lists','preview','anchor','pagebreak','image','wordcount','fullscreen','directionality'
        ],
        'toolbar' => 'undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | image | bullist numlist outdent indent | link',
        'relative_urls' => false,
        'use_lfm' => true,
        'use_dark' => true,
        'lfm_url' => 'filemanager',
        'file_picker_callback' => 'function(callback, value, meta) {
            console.log("File picker callback triggered", meta);
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName("body")[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName("body")[0].clientHeight;
            var cmsURL = "/filemanager" + "?editor=" + meta.fieldname;
            if (meta.filetype == "image") {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }
            console.log("Opening file manager at:", cmsURL);
            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : "Filemanager",
                width : x * 0.8,
                height : y * 0.8,
                resizable : "yes",
                close_previous : "no"
            }, {
                oninsert: function(url) {
                    console.log("File selected:", url);
                    callback(url);
                }
            });
        }',
        'setup' => 'function(editor) {
            console.log("TinyMCE editor setup");
            editor.on("init", function() {
                console.log("TinyMCE editor initialized");
            });
        }',
    ],
];
