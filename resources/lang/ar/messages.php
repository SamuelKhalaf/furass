<?php

return [
    // Authentication Messages
    'login_success' => 'تم تسجيل الدخول بنجاح.',
    'login_failed' => 'بيانات الاعتماد هذه غير متطابقة مع سجلاتنا.',
    'logout_success' => 'تم تسجيل الخروج بنجاح.',
    'password_reset_sent' => 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.',
    'password_reset_success' => 'تم إعادة تعيين كلمة المرور بنجاح.',
    'password_reset_failed' => 'تعذر إعادة تعيين كلمة المرور.',
    'email_verification_sent' => 'تم إرسال رابط التحقق إلى بريدك الإلكتروني.',
    'email_verified' => 'تم التحقق من البريد الإلكتروني بنجاح.',
    'email_not_verified' => 'يرجى التحقق من عنوان بريدك الإلكتروني.',

    // CRUD Messages
    'created' => 'تم إنشاء :item بنجاح.',
    'updated' => 'تم تحديث :item بنجاح.',
    'deleted' => 'تم حذف :item بنجاح.',
    'not_found' => ':item غير موجود.',
    'already_exists' => ':item موجود بالفعل.',
    'cannot_delete' => 'لا يمكن حذف :item لأنه مرتبط بسجلات أخرى.',
    'cannot_update' => 'لا يمكن تحديث :item.',
    'cannot_create' => 'لا يمكن إنشاء :item.',

    // Validation Messages
    'required' => 'حقل :attribute مطلوب.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالحًا.',
    'min' => 'يجب أن يحتوي :attribute على :min أحرف على الأقل.',
    'max' => 'يجب ألا يتجاوز :attribute :max حرفًا.',
    'unique' => 'تم استخدام :attribute بالفعل.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'password_min' => 'يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل.',
    'password_mixed' => 'يجب أن تحتوي كلمة المرور على حرف كبير وحرف صغير على الأقل.',
    'password_numbers' => 'يجب أن تحتوي كلمة المرور على رقم واحد على الأقل.',
    'password_special' => 'يجب أن تحتوي كلمة المرور على حرف خاص واحد على الأقل.',

    // File Upload Messages
    'file_uploaded' => 'تم رفع الملف بنجاح.',
    'file_deleted' => 'تم حذف الملف بنجاح.',
    'file_too_large' => 'الملف كبير جدًا. الحد الأقصى للحجم هو :size.',
    'file_invalid' => 'نوع ملف غير صالح. الأنواع المسموح بها هي: :types.',
    'file_not_found' => 'الملف غير موجود.',

    // Permission Messages
    'unauthorized' => 'غير مصرح لك بتنفيذ هذا الإجراء.',
    'forbidden' => 'الوصول ممنوع.',
    'login_required' => 'يرجى تسجيل الدخول للمتابعة.',
];
