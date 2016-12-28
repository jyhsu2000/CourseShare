<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//首頁
Route::get('/', 'HomeController@index')->name('index');

//會員（須完成信箱驗證）
Route::group(['middleware' => ['auth', 'email']], function () {
    //一般使用者
    //課表
    Route::get('courseTable/data', 'CourseTableController@data')->name('courseTable.data');
    Route::post('courseTable/sort', 'CourseTableController@sort')->name('courseTable.sort');
    Route::post('courseTable/togglePublic/{courseTable}', 'CourseTableController@togglePublic')
        ->name('courseTable.togglePublic');
    Route::get('courseTable/my', 'CourseTableController@my')->name('courseTable.my');
    Route::resource('courseTable', 'CourseTableController', [
        'except' => [
            'create',
            'edit',
        ],
    ]);
    //課程
    Route::post('course/addToTable/{course}', 'CourseController@addToTable')->name('course.addToTable');
    Route::post('course/removeFromTable/{course}', 'CourseController@removeFromTable')->name('course.removeFromTable');
    Route::resource('course', 'CourseController');
    //教師
    Route::resource('teacher', 'TeacherController', [
        'only' => [
            'index',
            'show',
        ],
    ]);
    //評價
    Route::resource('rate', 'RateController', [
        'only' => [
            'store',
            'update',
        ],
    ]);
    //空堂分析
    Route::get('analysis', 'AnalysisController@index')->name('analysis.index');
    Route::get('analysis/add/{courseTable}', 'AnalysisController@add')->name('analysis.add');
    Route::get('analysis/remove/{courseTable}', 'AnalysisController@remove')->name('analysis.remove');
    //管理員
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
        //課表
        //權限：courseTable.manage
        Route::group(['middleware' => 'permission:courseTable.manage'], function () {
            Route::resource('courseTable', 'CourseTableController', [
                'only' => [
                    'index',
                    'destroy',
                ],
            ]);
        });
        //課程
        //權限：course.manage
        Route::group(['middleware' => 'permission:course.manage'], function () {
            Route::post('course/import', 'CourseController@import')->name('course.import');
            Route::resource('course', 'CourseController');
        });
        //教師
        //權限：teacher.manage
        Route::group(['middleware' => 'permission:teacher.manage'], function () {
            Route::resource('teacher', 'TeacherController', [
                'except' => [
                    'create',
                    'edit',
                    'update',
                ],
            ]);
        });
    });

    //會員管理
    //權限：user.manage、user.view
    Route::resource('user', 'UserController', [
        'except' => [
            'create',
            'store',
        ],
    ]);
    //角色管理
    //權限：role.manage
    Route::group(['middleware' => 'permission:role.manage'], function () {
        Route::resource('role', 'RoleController', [
            'except' => [
                'show',
            ],
        ]);
    });
    //會員資料
    Route::group(['prefix' => 'profile'], function () {
        //查看會員資料
        Route::get('/', 'ProfileController@getProfile')->name('profile');
        //編輯會員資料
        Route::get('edit', 'ProfileController@getEditProfile')->name('profile.edit');
        Route::put('update', 'ProfileController@updateProfile')->name('profile.update');
    });
});

//會員系統
//將 Auth::routes() 複製出來自己命名
Route::group(['namespace' => 'Auth'], function () {
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::post('logout', 'LoginController@logout')->name('logout');
    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register')->name('register');
    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
    //修改密碼
    Route::get('password/change', 'PasswordController@getChangePassword')->name('password.change');
    Route::put('password/change', 'PasswordController@putChangePassword')->name('password.change');
    //驗證信箱
    Route::get('resend', 'RegisterController@resendConfirmMailPage')->name('confirm-mail.resend');
    Route::post('resend', 'RegisterController@resendConfirmMail')->name('confirm-mail.resend');
    Route::get('confirm/{confirmCode}', 'RegisterController@emailConfirm')->name('confirm');
});
