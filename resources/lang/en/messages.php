<?php

return [
    // Authentication Messages
    'login_success' => 'Successfully logged in.',
    'login_failed' => 'These credentials do not match our records.',
    'logout_success' => 'Successfully logged out.',
    'password_reset_sent' => 'Password reset link has been sent to your email.',
    'password_reset_success' => 'Password has been reset successfully.',
    'password_reset_failed' => 'Unable to reset password.',
    'email_verification_sent' => 'Verification link has been sent to your email.',
    'email_verified' => 'Email has been verified successfully.',
    'email_not_verified' => 'Please verify your email address.',

    // CRUD Messages
    'created' => ':item has been created successfully.',
    'updated' => ':item has been updated successfully.',
    'deleted' => ':item has been deleted successfully.',
    'not_found' => ':item not found.',
    'already_exists' => ':item already exists.',
    'cannot_delete' => 'Cannot delete :item because it is associated with other records.',
    'cannot_update' => 'Cannot update :item.',
    'cannot_create' => 'Cannot create :item.',

    // Validation Messages
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'min' => 'The :attribute must be at least :min characters.',
    'max' => 'The :attribute may not be greater than :max characters.',
    'unique' => 'The :attribute has already been taken.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'password_min' => 'The password must be at least 8 characters.',
    'password_mixed' => 'The password must contain at least one uppercase and one lowercase letter.',
    'password_numbers' => 'The password must contain at least one number.',
    'password_special' => 'The password must contain at least one special character.',

    // File Upload Messages
    'file_uploaded' => 'File has been uploaded successfully.',
    'file_deleted' => 'File has been deleted successfully.',
    'file_too_large' => 'File is too large. Maximum size is :size.',
    'file_invalid' => 'Invalid file type. Allowed types are: :types.',
    'file_not_found' => 'File not found.',

    // Permission Messages
    'unauthorized' => 'You are not authorized to perform this action.',
    'forbidden' => 'Access forbidden.',
    'login_required' => 'Please login to continue.',
];
