<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'لم ينجح نموذج المشاركة هذا في اجتياز اختبارات الأمان.';

// Login
$lang['login_heading']         = 'تسجيل الدخول';
$lang['login_subheading']      = 'يرجى تسجيل الدخول باستخدام البريد الإلكتروني / اسم المستخدم وكلمة المرور أدناه.';
$lang['login_identity_label']  = 'البريد الالكتروني / اسم المستخدم:';
$lang['login_password_label']  = 'كلمه السر:';
$lang['login_remember_label']  = 'تذكرنى:';
$lang['login_submit_btn']      = 'تسجيل الدخول';
$lang['login_forgot_password'] = 'نسيت رقمك السري؟';

// Index
$lang['index_heading']           = 'المستخدمين';
$lang['index_subheading']        = 'فيما يلي قائمة بالمستخدمين.';
$lang['index_fname_th']          = 'الاسم الاول';
$lang['index_lname_th']          = 'الكنية';
$lang['index_email_th']          = 'البريد الإلكتروني';
$lang['index_groups_th']         = 'المجموعات';
$lang['index_status_th']         = 'الحالة';
$lang['index_action_th']         = 'عمل';
$lang['index_active_link']       = 'نشيط';
$lang['index_inactive_link']     = 'غير نشط';
$lang['index_create_user_link']  = 'قم بإنشاء مستخدم جديد';
$lang['index_create_group_link'] = 'قم بإنشاء مجموعة جديدة';

// Deactivate User
$lang['deactivate_heading']                  = 'إلغاء تنشيط المستخدم';
$lang['deactivate_subheading']               = 'هل أنت متأكد من أنك تريد إلغاء تنشيط المستخدم \'%s\'';
$lang['deactivate_confirm_y_label']          = 'نعم فعلا:';
$lang['deactivate_confirm_n_label']          = 'لا:';
$lang['deactivate_submit_btn']               = 'خضع';
$lang['deactivate_validation_confirm_label'] = 'التأكيد';
$lang['deactivate_validation_user_id_label'] = 'معرف المستخدم';

// Create User
$lang['create_user_heading']                           = 'انشاء المستخدم';
$lang['create_user_subheading']                        = 'يرجى إدخال معلومات المستخدمين أدناه.';
$lang['create_user_fname_label']                       = 'الاسم الاول:';
$lang['create_user_lname_label']                       = 'الكنية:';
$lang['create_user_identity_label']                    = 'هوية:';
$lang['create_user_company_label']                     = 'اسم الشركة:';
$lang['create_user_email_label']                       = 'البريد الإلكتروني:';
$lang['create_user_phone_label']                       = 'هاتف:';
$lang['create_user_password_label']                    = 'كلمه السر:';
$lang['create_user_password_confirm_label']            = 'تأكيد كلمة المرور:';
$lang['create_user_submit_btn']                        = 'انشاء المستخدم';
$lang['create_user_validation_fname_label']            = 'الاسم الاول';
$lang['create_user_validation_lname_label']            = 'الكنية';
$lang['create_user_validation_identity_label']         = 'هوية';
$lang['create_user_validation_email_label']            = 'عنوان البريد الإلكتروني';
$lang['create_user_validation_phone_label']            = 'هاتف';
$lang['create_user_validation_company_label']          = 'اسم الشركة';
$lang['create_user_validation_password_label']         = 'كلمه السر';
$lang['create_user_validation_password_confirm_label'] = 'تأكيد كلمة المرور';

// Edit User
$lang['edit_user_heading']                           = 'تحرير العضو';
$lang['edit_user_subheading']                        = 'يرجى إدخال معلومات المستخدمين أدناه.';
$lang['edit_user_fname_label']                       = 'الاسم الاول:';
$lang['edit_user_lname_label']                       = 'الكنية:';
$lang['edit_user_company_label']                     = 'اسم الشركة:';
$lang['edit_user_email_label']                       = 'البريد الإلكتروني:';
$lang['edit_user_phone_label']                       = 'هاتف:';
$lang['edit_user_password_label']                    = 'كلمة المرور: (في حالة تغيير كلمة المرور)';
$lang['edit_user_password_confirm_label']            = 'تأكيد كلمة المرور: (في حالة تغيير كلمة المرور)';
$lang['edit_user_groups_heading']                    = 'عضو المجموعات';
$lang['edit_user_submit_btn']                        = 'حفظ المستخدم';
$lang['edit_user_validation_fname_label']            = 'الاسم الاول';
$lang['edit_user_validation_lname_label']            = 'الكنية';
$lang['edit_user_validation_email_label']            = 'عنوان البريد الإلكتروني';
$lang['edit_user_validation_phone_label']            = 'هاتف';
$lang['edit_user_validation_company_label']          = 'اسم الشركة';
$lang['edit_user_validation_groups_label']           = 'المجموعات';
$lang['edit_user_validation_password_label']         = 'كلمه السر';
$lang['edit_user_validation_password_confirm_label'] = 'تأكيد كلمة المرور';

// Create Group
$lang['create_group_title']                  = 'إنشاء مجموعة';
$lang['create_group_heading']                = 'إنشاء مجموعة';
$lang['create_group_subheading']             = 'يرجى إدخال معلومات المجموعة أدناه.';
$lang['create_group_name_label']             = 'أسم المجموعة:';
$lang['create_group_desc_label']             = 'وصف:';
$lang['create_group_submit_btn']             = 'إنشاء مجموعة';
$lang['create_group_validation_name_label']  = 'أسم المجموعة';
$lang['create_group_validation_desc_label']  = 'وصف';

// Edit Group
$lang['edit_group_title']                  = 'تحرير المجموعة';
$lang['edit_group_saved']                  = 'المجموعة المحفوظة';
$lang['edit_group_heading']                = 'تحرير المجموعة';
$lang['edit_group_subheading']             = 'يرجى إدخال معلومات المجموعة أدناه.';
$lang['edit_group_name_label']             = 'أسم المجموعة:';
$lang['edit_group_desc_label']             = 'وصف:';
$lang['edit_group_submit_btn']             = 'حفظ المجموعة';
$lang['edit_group_validation_name_label']  = 'أسم المجموعة';
$lang['edit_group_validation_desc_label']  = 'وصف';

// Change Password
$lang['change_password_heading']                               = 'تغيير كلمة السر';
$lang['change_password_old_password_label']                    = 'كلمة المرور القديمة:';
$lang['change_password_new_password_label']                    = 'كلمة المرور الجديدة (على الأقل %s حرفاً):';
$lang['change_password_new_password_confirm_label']            = 'تأكيد كلمة المرور الجديدة:';
$lang['change_password_submit_btn']                            = 'يتغيرون';
$lang['change_password_validation_old_password_label']         = 'كلمة المرور القديمة';
$lang['change_password_validation_new_password_label']         = 'كلمة السر الجديدة';
$lang['change_password_validation_new_password_confirm_label'] = 'تأكيد كلمة المرور الجديدة';

// Forgot Password
$lang['forgot_password_heading']                 = 'هل نسيت كلمة المرور';
$lang['forgot_password_subheading']              = 'يرجى إدخال %s حتى نتمكن من إرسال بريد إلكتروني إليك لإعادة تعيين كلمة المرور الخاصة بك.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'خضع';
$lang['forgot_password_validation_email_label']  = 'عنوان البريد الإلكتروني';
$lang['forgot_password_username_identity_label'] = 'اسم المستخدم';
$lang['forgot_password_email_identity_label']    = 'البريد الإلكتروني';
$lang['forgot_password_email_not_found']         = 'لا يوجد سجل لعنوان البريد الإلكتروني هذا.';
$lang['forgot_password_identity_not_found']      = 'لا يوجد سجل لعنوان اسم المستخدم هذا.';

// Reset Password
$lang['reset_password_heading']                               = 'تغيير كلمة السر';
$lang['reset_password_new_password_label']                    = 'كلمة المرور الجديدة (على الأقل %s حرفاً):';
$lang['reset_password_new_password_confirm_label']            = 'تأكيد كلمة المرور الجديدة:';
$lang['reset_password_submit_btn']                            = 'يتغيرون';
$lang['reset_password_validation_new_password_label']         = 'كلمة السر الجديدة';
$lang['reset_password_validation_new_password_confirm_label'] = 'تأكيد كلمة المرور الجديدة';

// Activation Email
$lang['email_activate_heading']    = 'تفعيل حساب %s';
$lang['email_activate_subheading'] = 'يرجى الضغط على هذا الرابط %s.';
$lang['email_activate_link']       = 'فعل حسابك';

// Forgot Password Email
$lang['email_forgot_password_heading']    = 'إعادة ضبط كلمة المرور لـ %s';
$lang['email_forgot_password_subheading'] = 'يرجى الضغط على هذا الرابط %s.';
$lang['email_forgot_password_link']       = 'اعد ضبط كلمه السر';

// New Password Email
$lang['email_new_password_heading']    = 'كلمة المرور الجديدة لـ %s';
$lang['email_new_password_subheading'] = 'تمت إعادة تعيين كلمة المرور الخاصة بك إلى: %s';
