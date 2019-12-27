<?php

function file_icon($mime_type)
{
    $icons = [
        'image' => 'fa-file-image',
        'audio' => 'fa-file-audio',
        'video' => 'fa-file-video',
        'application/pdf' => 'fa-file-pdf',
        'application/msword' => 'fa-file-word',
        'application/vnd.ms-word' => 'fa-file-word',
        'application/vnd.oasis.opendocument.text' => 'fa-file-word',
        'application/vnd.openxmlformats-officedocument.wordprocessingml' => 'fa-file-word',
        'application/vnd.ms-excel' => 'fa-file-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml' => 'fa-file-excel',
        'application/vnd.oasis.opendocument.spreadsheet' => 'fa-file-excel',
        'application/vnd.ms-powerpoint' => 'fa-file-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml' => 'fa-file-powerpoint',
        'application/vnd.oasis.opendocument.presentation' => 'fa-file-powerpoint',
        'text/plain' => 'fa-file-alt',
        'text/html' => 'fa-file-code',
        'application/json' => 'fa-file-code',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fa-file-word',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'fa-file-excel',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'fa-file-powerpoint',
        'application/gzip' => 'fa-file-archive',
        'application/zip' => 'fa-file-archive',
        'application/x-zip-compressed' => 'fa-file-archive',
        'application/octet-stream' => 'fa-file-archive',
    ];

    if (isset($icons[$mime_type])) return $icons[$mime_type];
    $mime_group = explode('/', $mime_type, 2)[0];
    return (isset($icons[$mime_group])) ? $icons[$mime_group] : 'fa-file';
}
