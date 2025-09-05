<?php

return [
    'default_options' => [
        'content_css' => '/vendor/tinymce/skins/ui/oxide/content.min.css',
        'skin_url' => '/vendor/tinymce/skins/ui/oxide',
        'content_css_dark' => '/vendor/tinymce/skins/ui/oxide-dark/content.min.css',
        'skin_url_dark' => '/vendor/tinymce/skins/ui/oxide-dark',
        'path_absolute' => '/',

        // Plugins (link already present; keeping image, lists, etc.)
        'plugins' => [
            'lists',
            'preview',
            'anchor',
            'pagebreak',
            'image',
            'wordcount',
            'fullscreen',
            'directionality',
            'link'
        ],

        // Add a custom "document" button next to the image button
        'toolbar' => 'undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | document image | bullist numlist outdent indent | link',

        // Allow both images and generic files in the picker
        'relative_urls' => false,
        'use_lfm' => true,
        'use_dark' => true,
        'lfm_url' => 'filemanager',
        'file_picker_types' => 'file image',

        // Unified file picker for images and files (documents)
        'file_picker_callback' => 'function(callback, value, meta) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

            var cmsURL = "/filemanager?editor=" + (meta.fieldname || "tinymce");
            if (meta.filetype === "image") {
                cmsURL += "&type=Images";
            } else {
                cmsURL += "&type=Files";
            }

            var win = tinyMCE.activeEditor.windowManager.openUrl({
                title: "File Manager",
                url: cmsURL,
                width: Math.floor(x * 0.8),
                height: Math.floor(y * 0.8),
                onMessage: function (api, details) {
                    // If your filemanager posts a message back with the URL
                    if (details.mceAction === "insert" && details.content && details.content.url) {
                        callback(details.content.url, { text: details.content.text || "" });
                        api.close();
                    }
                }
            });

            // Fallback for filemanagers (like LFM) that call window.SetUrl(url)
            window.SetUrl = function (url, file_path) {
                // For images, TinyMCE handles it; for files, we pass link text as filename
                var filename = (url || "").split("/").pop() || "Document";
                if (meta.filetype === "image") {
                    callback(url);
                } else {
                    callback(url, { text: filename });
                }
                try { win && win.close(); } catch (e) {}
            };
        }',

        'setup' => 'function(editor) {
            // Add a custom "document" toolbar button (paper/new-document icon)
            editor.ui.registry.addButton("document", {
                tooltip: "Insert document",
                icon: "new-document",
                onAction: function() {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                    var y = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

                    var cmsURL = "/filemanager?editor=tinymce&type=Files";

                    var win = editor.windowManager.openUrl({
                        title: "Select Document",
                        url: cmsURL,
                        width: Math.floor(x * 0.8),
                        height: Math.floor(y * 0.8),
                        onMessage: function (api, details) {
                            if (details.mceAction === "insert" && details.content && details.content.url) {
                                var url = details.content.url;
                                var filename = (url || "").split("/").pop() || "Document";
                                editor.insertContent("<a href=\"" + url + "\" target=\"_blank\" rel=\"noopener\">" + filename + "</a>");
                                api.close();
                            }
                        }
                    });

                    // Fallback callback for LFM-style integrations
                    window.SetUrl = function (url, file_path) {
                        var filename = (url || "").split("/").pop() || "Document";
                        editor.insertContent("<a href=\"" + url + "\" target=\"_blank\" rel=\"noopener\">" + filename + "</a>");
                        try { win && win.close(); } catch (e) {}
                    };
                }
            });

            editor.on("init", function() {
                // ready
            });
        }',
    ],
];
