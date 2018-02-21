<?php

return [

    /**
     * Relative path to Uploads storage. Where the files will be stored
     * Usually a directory in the public/folder
     * Defaults to uploads
     *
     */
    'uploads_path'    => public_path('uploads'),

    /**
     * Whether or not to force users to be authenticated before submitting media
     * This comes in handy when one
     */
    'force_auth'      => true,

    /**
     * The number of maximum files to be uploaded on any instance of Dropozone
     * This corresponds to the maxFiles parameter in dropzone.js
     *
     */
    'maximum_files'   => 10,

    /**
     * @param file_types
     * Corresponds to Dropzone acceptedFiles parameter
     */
    'file_types'      => ".jpeg,.jpg,.png,.gif,.zip,.tar",

    /**
     * Whether to use the database to store uploaded file info
     */
    'use_database'    =>false,
];
