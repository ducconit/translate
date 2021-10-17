# Laravel Translate Module Sphoton

*Coded by Trung Đức(DNT)*

### Install
`composer require dnt/translate`


### Start

 Các route sử dụng đa ngôn ngữ phải được đặt trong Closure function của method localization
 ```php
// routes/web.php
 use Illuminate\Support\Facades\Route;

Route::localization(function(){

// ###############
    //get
    Route::get('/',function(){
        return view('welcome');
    })->name('index');

    // group
    Route::prefix('admin')->group(function(){
        return view('welcome-admin');
    });
//............


});

 ```

### Option
method localization của Route có thể nhận thêm tham số thứ 2 để sửa lại 1 số cấu hình có sẵn của module này
```php
use Illuminate\Support\Facades\Route;

Route::localization(function(){
// list routes
},[
// Tắt route chuyển vùng mặc định
    'use-route-change-locale'=> false// default: true
// Sử dụng middleware tự động chuyển ngôn ngữ dựa theo url
    'use-locale-middleware'=>false// default: true
]);
```
