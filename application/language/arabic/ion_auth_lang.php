<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - Arabic
*
* Author: Emad Elsaid
* 		  blazeeboy@gmail.com
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  30.08.2010
*
* Description:  Arabic language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful']            = 'تم انشاء حسابك بنجاح';
$lang['account_creation_unsuccessful']          = 'حدث خطأ اثناء انشاء حسابك لدينا';
$lang['account_creation_duplicate_email'] 	    = 'هذا البريد الإلكترونى تم استخدامه من قبل او غير صحيح';
$lang['account_creation_duplicate_identity']    = 'اسم المستخدم تم التسجيل به من قبل او غير صحيح';
$lang['account_creation_missing_default_group'] = 'لم يتم تعيين المجموعة الافتراضية';
$lang['account_creation_invalid_default_group'] = 'اسم مجموعة افتراضية غير صحيحة';


// Password
$lang['password_change_successful']   = 'تم تغيير كلمة السر';
$lang['password_change_unsuccessful'] = 'لا يمكن تغيير كلمة السر';
$lang['forgot_password_successful']   = 'تم ارسال بريد لإستعادة كلمة السر';
$lang['forgot_password_unsuccessful'] = 'لا يمكن استعادة كلمة السر';

// Activation
$lang['activate_successful']            = 'تم تفعيل حسابك';
$lang['activate_unsuccessful']          = 'لا يمكن تفعيل حسابك';
$lang['deactivate_successful']          = 'تم إيقاف حسابك';
$lang['deactivate_unsuccessful']        = 'لا يمكن إيقاف حسابك';
$lang['activation_email_successful']    = 'تم إرسال بريد التفعيل';
$lang['activation_email_unsuccessful']  = 'لا يمكن ارسال بريد التفعيل';
$lang['deactivate_current_user_unsuccessful']= 'لا يمكنك إلغاء تنشيط نفسك.';

// Login / Logout
$lang['login_successful']             = 'تم تسجيل الدخول بنجاح';
$lang['login_unsuccessful']           = 'معلومات الدخول غير صحيحة';
$lang['login_unsuccessful_not_active']= 'الحساب غير نشط';
$lang['login_timeout']                = 'مغلق مؤقتا. حاول مرة أخرى في وقت لاحق.';
$lang['logout_successful']            = 'تم تسجيل خروجك';

// Account Changes
$lang['update_successful'] 		 	 = 'تم تعديل معلومات حسابك';
$lang['update_unsuccessful'] 		 	 = 'لا يمكن تعديل معلومات الحساب';
$lang['delete_successful'] 		 	 = 'تم إلغاء المستخدم';
$lang['delete_unsuccessful'] 		 	 = 'لا يمكن إلغاء المستخدم';

// Groups
$lang['group_creation_successful']        = 'المجموعة التي تم إنشاؤها بنجاح';
$lang['group_already_exists']             = 'اسم المجموعة مأخوذ بالفعل';
$lang['group_update_successful']          = 'تفاصيل المجموعة محدثة';
$lang['group_delete_successful']          = 'المجموعة المحذوفة';
$lang['group_delete_unsuccessful']        = 'غير قادر على حذف المجموعة';
$lang['group_delete_notallowed']          = 'لا يمكن حذف مجموعة المسؤولين';;
$lang['group_name_required']              = 'اسم المجموعة هو حقل مطلوب';
$lang['group_name_admin_not_alter']       = 'لا يمكن تغيير اسم مجموعة المسؤول';
$lang['email_activation_subject']         = 'تفعيل الحساب';
$lang['email_activate_heading']           = 'تنشيط الحساب لـ %s';
$lang['email_activate_subheading']        = 'الرجاء النقر فوق هذا الارتباط إلى %s.';
$lang['email_activate_link']              = 'فعل حسابك';
$lang['email_forgotten_password_subject'] = 'نسيت كلمة السر التحقق';
$lang['email_forgot_password_heading']    = 'إعادة تعيين كلمة المرور لـ %s';
$lang['email_forgot_password_subheading'] = 'الرجاء النقر فوق هذا الارتباط إلى٪ s.';
$lang['email_forgot_password_link']       = 'اعد ضبط كلمه السر';
$lang['email_new_password_subject']       = 'كلمة السر الجديدة';
$lang['email_new_password_heading']       = 'كلمة مرور جديدة لـ %s';
$lang['email_new_password_subheading']    = 'تمت إعادة تعيين كلمة المرور الخاصة بك إلى: %s';