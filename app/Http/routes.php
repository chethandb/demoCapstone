<?php

use App\Http\Middleware;
Route::auth();

Route::get('/', function () {
    if (!Auth::check()) {
        return view('auth/login');
    } else {
        return back();
    }
});

Route::get('php-version', function () {
    return phpinfo();
});

Route::get('laravel-version', function () {
    $laravel = app();
    return 'Your Laravel Version is ' . $laravel::VERSION;
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::auth();
Route::get('/home', 'HomeController@index');


Route::get('check-session', 'Auth\AuthController@checkSession');
Route::get('changepasswordpage', 'Auth\AuthController@showUpdatePassword');
Route::post('change-password', 'Auth\AuthController@updatePassword');

Route::get('apartment/update/{id}', 'ApartmentsController@edit');
Route::get('apartment/update information/{id}', 'ApartmentsController@update');
Route::get('apartment/destroy/{id}', 'ApartmentsController@destroy');

Route::resource('apartment', 'ApartmentsController');

Route::get('center/update/{id}', 'CenterController@edit');
Route::get('center/update information/{id}', 'CenterController@update');
Route::get('center/destroy/{id}', 'CenterController@destroy');
Route::resource('/center', 'CenterController');

Route::get('rescontact/update/{id}', 'RescontactsController@edit');
Route::get('rescontact/update information/{id}', 'RescontactsController@update');
Route::get('rescontact/destroy/{id}', 'RescontactsController@destroy');

Route::resource('/rescontact', 'RescontactsController');

Route::get('/resident/update/{id}', 'ResidentsController@edit');
Route::get('/resident/update information/{id}', 'ResidentsController@update');

Route::get('resident/destroy/{id}', 'ResidentsController@destroy');

Route::resource('/resident','ResidentsController');


Route::get('commonarea/update/{id}', 'CommonareaController@edit');
Route::get('commonarea/update information/{id}', 'CommonareaController@update');
Route::get('commonarea/destroy/{id}', 'CommonareaController@destroy');

Route::resource('/commonarea', 'CommonareaController');

Route::get('/Supply/update/{id}', 'SupplyController@edit');
Route::get('/Supply/update information/{id}', 'SupplyController@update');

Route::get('/Supply/destroy/{id}', 'SupplyController@destroy');

Route::resource('/Supply','SupplyController');

Route::get('/tool/update/{id}', 'ToolsController@edit');
Route::get('/tool/update information/{id}', 'ToolsController@update');
Route::get('tool/destroy/{id}', 'ToolsController@destroy');

Route::resource('/tool','ToolsController');

Route::get('/issuetype/update/{id}', 'IssuetypesController@edit');
Route::get('/issuetype/update information/{id}', 'IssuetypesController@update');
Route::get('issuetype/destroy/{id}', 'IssuetypesController@destroy');

Route::resource('/issuetype','IssuetypesController');


Route::resource('notifications', 'NotificationController');


Route::get('/report','ReportController@index');
Route::post('/report/store', 'ReportController@store');
Route::resource('/report','ReportController');


Route::get('/getAptDetailsRes', 'ReportController@getAptDetails');

Route::get('/excel/download', 'ReportController@excel');


Route::resource('users', 'UsersController');



Route::resource('roles', 'RolesController');

Route::resource('orders', 'WorkOrderController');

    Route::resource('/workorder', 'WorkOrderController@index');
    Route::resource('/readworkorder', 'WorkOrderController@show');
    Route::resource('/readworkorderhistory', 'WorkOrderController@getHistoryShow');
    Route::resource('/workorderview', 'WorkOrderController@view');
    Route::post('/workorder/storeData', 'WorkOrderController@storeData');
    Route::post('/workorder/updateData', 'WorkOrderController@updateData');
    Route::get('/workorder/edit/{wo_id}', 'WorkOrderController@edit');
    Route::get('/history', 'WorkOrderController@getHistory');



Route::get('/reset', 'Auth\AuthController@showPasswordEmailPage');

Route::get('/createPassword/{id}', 'Auth\PasswordController@showUserPasswordChange');

Route::post('/createNewPassword', 'Auth\PasswordController@createNewPassword');

Route::get('/getAptDetails', 'WorkOrderController@getAptDetails');
Route::get('/getComAreaDetails', 'WorkOrderController@getComAreaDetails');
Route::get('/getResidentName', 'WorkOrderController@getResidentName');
Route::get('/getIssueDesc', 'WorkOrderController@getIssueDesc');
Route::get('/getresidentComments', 'WorkOrderController@getresidentComments');
Route::get('/getUnitPrice', 'WorkOrderController@getUnitPrice');
Route::get('/getComments', 'WorkOrderController@getComments');
Route::post('/postComment', 'WorkOrderController@addComment');
Route::get('/getAptDetailRes', 'ResidentsController@getAptDet');
Route::get('/getContactDetails', 'UsersController@getContactDetails');

Route::post('/sendemail', function () {
    session_start();
    $user_id = DB::table('users')->where('email', $_POST['email'])->value('id');

    if ($user_id != null) {
        $data = array(
            'name' => $_POST['email'],
        );

        $_SESSION['user_id'] = $user_id;

        error_log('Value of User ID for email password reset - ' . $user_id);

        $noti_status = DB::table('notifications')->where('noti_type', 'Password Reset')->value('noti_status');
        if ($noti_status == 'Active') {
            Mail::send('emails.welcome', $data, function ($message) {
                $message->from('newcassel@domain.com', 'New Cassel Work Order System');
                $message->to($_POST['email'])
                    ->subject($noti_email_title = DB::table('notifications')->where('noti_type', 'Password Reset')->value('noti_email_title'));
            });
        }

        return view('auth.passwords.emailconfirmation');
    } else {
        return view('auth.passwords.usernotfound');
    }


});