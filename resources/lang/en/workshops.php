<?php

return [
    // Page titles and headers
    'title' => 'Workshops',
    'list' => 'Workshops List',
    'create' => 'Create Workshop',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'view' => 'View Workshop',
    'back_to_list' => 'Back to Workshops List',

    // Table columns
    'name' => 'Name',
    'company_name' => 'Company',
    'location' => 'Location',
    'date' => 'Date',
    'media' => 'Media',
    'documents' => 'Documents',
    'description' => 'Description',
    'programs' => 'Programs',
    'event_type' => 'Event Type',
    'workshops_count' => 'Workshops Count',
    'status' => 'Status',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
    'actions' => 'Actions',
    'search' => 'Search Workshops',
    'no_workshops' => 'No workshops found',
    'loading' => 'Loading...',
    'processing' => 'Processing...',

    // Status options
    'status_options' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],

    // Messages
    'messages' => [
        'created' => 'Workshop created successfully',
        'updated' => 'Workshop updated successfully',
        'deleted' => 'Workshop deleted successfully',
        'delete_failed' => 'Failed to delete workshop',
        'not_found' => 'Workshop not found',
        'update_failed' => 'Failed to update workshop',
        'create_failed' => 'Failed to create workshop',
        'file_uploaded' => 'File uploaded successfully',
        'file_upload_failed' => 'Failed to upload file',
        'file_deleted' => 'File deleted successfully',
        'file_delete_failed' => 'Failed to delete file',
        'invalid_file' => 'Invalid file. Please check the file type and size',
    ],

    // Confirmation dialogs
    'confirm' => [
        'delete' => [
            'title' => 'Delete Workshop',
            'message' => 'Are you sure you want to delete this workshop? This action cannot be undone.',
            'button' => 'Yes, delete it!',
            'cancel' => 'Cancel',
        ],
        'cancel' => [
            'title' => 'Cancel Changes',
            'message' => 'Are you sure you want to cancel? All unsaved changes will be lost.',
            'button' => 'Yes, cancel',
            'cancel' => 'No, continue editing',
        ],
    ],

    // Buttons
    'buttons' => [
        'add' => 'Add New',
        'create' => 'Create Workshop',
        'edit' => 'Edit',
        'update' => 'Update',
        'delete' => 'Delete',
        'view' => 'View',
        'save' => 'Save Changes',
        'cancel' => 'Cancel',
        'close' => 'Close',
        'back' => 'Back',
        'preview' => 'Preview',
        'download' => 'Download',
        'remove' => 'Remove',
        'upload' => 'Upload',
        'browse' => 'Browse',
        'clear' => 'Clear',
        'reset' => 'Reset',
        'submit' => 'Submit',
        'search' => 'Search',
        'filter' => 'Filter',
        'export' => 'Export',
        'import' => 'Import',
        'print' => 'Print',
        'send' => 'Send',
        'ok' => 'OK',
        'yes' => 'Yes',
        'no' => 'No',
        'confirm' => 'Confirm',
    ],

    // Modal
    'modal' => [
        'add_workshop' => 'Add New Workshop',
        'edit_workshop' => 'Edit',
        'view_workshop' => 'View',
        'update_workshop' => 'Update Workshop Details',
        'workshop_name' => 'Name',
        'company_name' => 'Company',
        'location' => 'Location',
        'enter_workshop_name' => 'Enter workshop name',
        'enter_company_name' => 'Enter company name',
        'enter_location' => 'Enter location',
        'event_date_time' => 'Event Date',
        'select_date_time' => 'Select Workshop date',
        'description' => 'Description',
        'enter_description' => 'Enter workshop description',
        'media' => 'Media File',
        'document' => 'Document',
        'allowed_media' => 'Allowed file types: JPG, JPEG, PNG, MP4. Max size: 10MB',
        'allowed_documents' => 'Allowed file types: PDF, DOC, DOCX, TXT. Max size: 10MB',
        'preview' => 'Preview',
        'programs' => 'Programs',
        'select_programs' => 'Select programs',
        'discard' => 'Discard',
        'submit' => 'Submit',
        'please_wait' => 'Please wait...',
        'loading' => 'Loading...',
        'saving' => 'Saving...',
        'updating' => 'Updating...',
        'deleting' => 'Deleting...',
    ],

    // File upload
    'file_upload' => [
        'select_file' => 'Select File',
        'change_file' => 'Change File',
        'remove_file' => 'Remove File',
        'no_file_selected' => 'No file selected',
        'file_selected' => 'file selected',
        'files_selected' => 'files selected',
        'drop_files_here' => 'Drop files here or click to upload',
        'uploading' => 'Uploading...',
        'upload_complete' => 'Upload complete',
        'upload_failed' => 'Upload failed',
        'file_too_large' => 'File is too large',
        'invalid_file_type' => 'Invalid file type',
        'max_file_size' => 'Max file size: :size',
        'allowed_file_types' => 'Allowed file types: :types',
        'preview_not_available' => 'Preview not available',
    ],

    // Preview modal
    'preview' => [
        'title' => 'File Preview',
        'close' => 'Close Preview',
        'download' => 'Download File',
        'loading' => 'Loading preview...',
        'error' => 'Error loading preview',
        'unsupported' => 'Preview not available for this file type',
    ],

    // Validation
    'validation' => [
        'event_name_required' => 'The workshop name field is required.',
        'company_name_required' => 'The company name field is required.',
        'location_required' => 'The location field is required.',
        'event_time_required' => 'The event time field is required.',
        'event_time_date' => 'The event time must be a valid date.',
        'programs_required' => 'At least one program must be selected.',
        'programs_array' => 'The programs must be an array.',
        'programs_exists' => 'One or more selected programs are invalid.',
        'media_file' => 'The media must be a file.',
        'media_mimes' => 'The media must be a file of type: jpeg, png, jpg, gif, webp, mp4, webm, ogg, pdf.',
        'media_max' => 'The media may not be greater than 10MB.',
        'document_file' => 'The document must be a file.',
        'document_mimes' => 'The document must be a file of type: pdf, doc, docx, xls, xlsx, txt.',
        'document_max' => 'The document may not be greater than 10MB.',
    ],

    // Tooltips
    'tooltips' => [
        'edit' => 'Edit this workshop',
        'delete' => 'Delete this workshop',
        'view' => 'View workshop details',
        'preview_media' => 'Preview media',
        'download_document' => 'Download document',
    ],

    // Help text
    'help' => [
        'event_name' => 'Enter a descriptive name for the workshop',
        'company_name' => 'Enter the name of the company organizing the workshop',
        'location' => 'Enter the location where the workshop will take place',
        'event_time' => 'Select the date and time of the workshop',
        'programs' => 'Select one or more programs associated with this workshop',
        'description' => 'Provide additional details about the workshop',
        'media' => 'Upload images, videos, or PDFs related to the workshop (max 10MB)',
        'documents' => 'Upload documents such as itineraries or forms (max 10MB)',
    ],

    // Breadcrumbs
    'breadcrumbs' => [
        'home' => 'Home',
        'workshops' => 'Workshops',
        'create' => 'Create Workshop',
        'edit' => 'Edit Workshop',
        'view' => 'View Workshop',
    ],
];
