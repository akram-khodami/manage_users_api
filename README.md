# سامانه مدیریت کاربران با احراز هویت و سطوح دسترسی

این پروژه یک API ساده برای مدیریت کاربران با استفاده از Laravel و احراز هویت مبتنی بر Sanctum است. همچنین نقش‌ها و مجوزها با استفاده از پکیج `spatie/laravel-permission` مدیریت می‌شوند.

## ویژگی‌ها

- ثبت‌نام و ورود کاربران
- دریافت توکن برای احراز هویت
- مشاهده پروفایل کاربر لاگین شده
- خروج از حساب کاربری (logout) و خروج از تمام نشست‌ها (logoutAll)
- پنل مدیریت برای کاربران با نقش ادمین:
  - مشاهده لیست کاربران
  - مشاهده جزئیات هر کاربر
  - ویرایش اطلاعات و نقش کاربر
  - حذف کاربر (به‌جز ادمین‌ها)
  - ایجاد کاربر جدید با نقش دلخواه

## پکیج‌های استفاده‌شده

- `laravel/sanctum` برای احراز هویت
- `spatie/laravel-permission` برای مدیریت نقش‌ها و مجوزها

## اجرای پروژه

1. کلون کردن پروژه:
   ```bash
   git clone https://github.com/akram-khodami/manage_users_api.git
   cd your-project

2. run seeder
   ```bash
   php artisan migrate --seed   
