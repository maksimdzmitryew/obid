<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Api\EventApi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Factory;
use Spatie\Permission\Models\Role;

$a_list = config('fragment.list');
$a_modules = config('fragment.modules');

Route::get('parse/{id?}',           ['as' => 'parse_provider',          'uses' => '\Modules\Provider\API\ProviderController@parse']);

/**
 * spell a Module's Controller name
 *
 * @param String    $s_model        Model located inside Module
 * @param String    $s_type         type of user access: guest, power, api
 *
 * @return Response json instance of
 */
$getCtrlName = function (String $s_model, String $s_type)
{
    $s_root     = 'Modules';
    $s_closure= 'Controller';
    $s_split    = '\\';
    $s_ctrl     = $s_split . $s_root . $s_split . $s_model . $s_split . $s_type . $s_split . $s_model . $s_closure;
    return $s_ctrl ;
};

/**
 * spell path name to be used in both URL and in 'as' alias
 *
 * @param String    $s_model        Model located inside Module
 * @param String    $s_parts        optional: URL parts
 *
 * @return String
 */
$getPath = function (String $s_model, String $s_parts = '') : String
{
    return strtolower($s_model) . $s_parts;
};

/**
 * combine 'as' and 'uses' params for route
 *
 * @param String    $s_model        Model located inside Module
 * @param String    $s_type         type of user access: guest, power, api
 * @param String    $s_method       name of function to be called within controller
 *
 * @return Array    params for route
 */
$getRoute = function (String $s_model, String $s_type, String $s_method) use ($getCtrlName, $getPath)
{
    $s_ctrl     = $getCtrlName($s_model, $s_type);
    $s_path     = $getPath($s_model);
    $s_res      = ['as' => $s_path . '.' . $s_method,   'uses' => $s_ctrl . '@' . $s_method];
    return $s_res ;
};

Route::group([
    'middleware' => []
], function() {

    # login and logout are built-in hardcoded Laravel default values
    Route::get('login',
        [
            'as'        => 'login',
            'uses'      =>
                            function(){
                            return redirect(route('signin_page'));
                            },
        ]
    );

    Route::get('signin',            ['as' => 'signin_page',         'uses' => 'Auth\SigninController@form']);
    Route::post('signin',           ['as' => 'signin_page',         'uses' => 'Auth\SigninController@core']);
    /**
     *  instead of GET to default route
     *  Route::get('logout',            ['as' => 'logout',              'uses' => 'Auth\LoginController@logout']);
     *  we do it with POST
     *  to custom route
     */
    Route::post('signout',      ['as' => 'signout_user',        'uses' => 'Auth\LoginController@logout']);

    // Registration
    Route::get('signup',            ['as' => 'signup_page',         'uses' => 'Auth\SignupController@form']);
    Route::post('signup',           ['as' => 'signup_user',         'uses' => 'Auth\SignupController@core']);
    Route::get('signup/{token}',    ['as' => 'signup_confirm',      'uses' => 'Auth\SignupController@confirm']);

    // Password Reset
    Route::get('reset',             ['as' => 'password_reset',      'uses' => 'Auth\PasswordController@form']);
    Route::post('reset',            ['as' => 'password_token',      'uses' => 'Auth\PasswordController@send']);
    Route::get('change/{token?}',   ['as' => 'password_change',     'uses' => 'Auth\PasswordController@new']);
    Route::post('change/{token?}',  ['as' => 'password_change',     'uses' => 'Auth\PasswordController@change']);
});

// Change language Route
Route::get('lang/{language}', ['as' => 'change-lang', 'uses' => 'LanguageController@changeLanguage']);

// Power routes
$s_type      = 'User';
Route::group([
    'as' => strtolower($s_type) . '.',
    'namespace' => $s_type,
    'middleware' => []
], function() use ($s_type, $getPath, $getRoute) {
    Route::group(['middleware' => 'auth'], function() use ($s_type, $getPath, $getRoute) {
        $s_model    = 'Page';
        $s_method   = 'download';
        Route::get($getPath($s_model, '/download/{format}'),                $getRoute($s_model, $s_type, $s_method));
    });
});

// Public routes
$s_type      = 'Guest';
Route::group([
    'as' => strtolower($s_type) . '.',
    'namespace' => $s_type,
    'middleware' => []
], function() use ($s_type, $getPath, $getRoute) {

    Route::get('attachment/{file_id}', [
        'as' => 'file.download',
        'uses' => '\App\Http\Controllers\Controller@downloadFile'
    ]);

    Route::get('unit/test',
        [
            'as'        => 'viewtest',
            'uses'      =>
                            function () {
                                return view('layouts.test', [
                                    'test_var' => 'some value',
                                ]);
                            },
        ]
    );

    $s_model    = 'Welcome';
    $s_method   = 'index';
    Route::get('/',                                                                                             $getRoute($s_model, $s_type, $s_method));

    $s_model    = 'Page';
    $s_method   = 'posibnyk';
    Route::get($getPath($s_model, '/{page_slug}'),                              $getRoute($s_model, $s_type, $s_method));


    Route::group(['middleware' => 'auth'], function() use ($s_type, $getPath, $getRoute) {
        $s_model    = 'Personal';
        $s_method   = 'profile';    Route::get('my/profile',                        $getRoute($s_model, $s_type, $s_method));
        $s_method   = 'update';     Route::post('my/profile',                       $getRoute($s_model, $s_type, $s_method));
        $s_method   = 'activity';   Route::get('my/activity',                       $getRoute($s_model, $s_type, $s_method));

        $s_model    = 'Demand';
        $s_method   = 'week';
        Route::get($getPath($s_model, '/' . $s_method),                         $getRoute($s_model, $s_type, $s_method));
        $s_method   = 'form';
        Route::get($getPath($s_model, '/add'),                                          $getRoute($s_model, $s_type, $s_method));
    });

});

//API Routes
$s_type      = 'API';
Route::group([
    'as' => strtolower($s_type) . '.',
    'prefix' => strtolower($s_type),
    'namespace' => $s_type,
    'middleware' => [],
], function() use ($s_type, $getPath, $getRoute, $a_list, $a_modules) {

    Route::group(['middleware' => 'auth'], function() use ($s_type, $getPath, $getRoute) {
        $s_model    = 'Page';
        $s_method   = 'order';
        Route::get($getPath($s_model, '/' . $s_method),                         $getRoute($s_model, $s_type, $s_method));
    });

    Route::post('users/{id}/password-change', ['as' => 'user.password-change', 'uses' => 'UserController@passwordChange']);

    Route::post('file', ['as' => 'upload.file', 'uses' => 'UploadController@file']);
    Route::post('image', ['as' => 'upload.image', 'uses' => 'UploadController@image']);

    for ($i = 0; $i < count($a_list); $i++)
    {
        $s_model = $a_list[$i];
        if (in_array($s_model, $a_modules))
        {
            $s_method   = 'index'; Route::get($getPath($s_model, '/list'),  $getRoute($s_model, $s_type, $s_method));
            Route::group(['middleware' => 'auth'], function() use ($s_type, $getPath, $getRoute, $s_model) {
                $s_method   = 'store'; Route::post($getPath($s_model),  $getRoute($s_model, $s_type, $s_method));
                $s_method   = 'update'; Route::post($getPath($s_model, '/{item}/edit'), $getRoute($s_model, $s_type, $s_method));
                $s_method   = 'destroy'; Route::post($getPath($s_model, '/delete'), $getRoute($s_model, $s_type, $s_method));
            });
        }

        //TODO remove when Users move to Modules
        //ATTN: these are restricted data even for listing
        else
        {
            $s_ctrl = '';
            $s_ctrl = $s_model;
            $s_path = strtolower($s_model);
            if (!empty($s_ctrl))
            {
                $s_ctrl .= 'Controller';
                Route::group(['middleware' => 'auth'], function() use ($s_path, $s_ctrl) {
                    Route::get($s_path . '/list',           ['as' => $s_path . '.index',    'uses' => $s_ctrl . '@index']);
                    Route::post($s_path,                    ['as' => $s_path . '.store',    'uses' => $s_ctrl . '@store']);
                    Route::post($s_path . '/{item}/edit',   ['as' => $s_path . '.update',   'uses' => $s_ctrl . '@update']);
                    Route::post($s_path . '/delete',        ['as' => $s_path . '.destroy','uses' => $s_ctrl . '@destroy']);
                });
            }
        }
        //
    }

});

//Admin Routes
Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'role:admin']
], function() use ($a_list, $a_modules) {
    Route::get('dashboard', ['as' => 'home', 'uses' => 'DashboardController@index']);
    Route::get('session', ['as' => 'session', 'uses' => 'DashboardController@session']);

    for ($i = 0; $i < count($a_list); $i++)
    {
        $s_ctrl = '';
        $s_model = $a_list[$i];
        if (in_array($s_model, $a_modules))
            $s_ctrl = '\Modules\\' . $s_model . '\User\\' . $s_model ;
        else
            $s_ctrl = $s_model;
        $s_path = strtolower($s_model);
        if (!empty($s_ctrl))
        {
            $s_ctrl .= 'Controller';
            Route::get($s_path . '/list',       ['as' => $s_path . '.index',    'uses' => $s_ctrl . '@index']);
            Route::get($s_path . '/form/{id?}', ['as' => $s_path . '.form',     'uses' => $s_ctrl . '@form']);
        }
    }
});

//Route::get('admin/clean', function(){
//
//    $empty_files = File::whereNull('filable_id')->get();
//
//    foreach($empty_files as $file){
//        Storage::delete($file->path);
//
//        if($file->path_medium){
//            Storage::delete($file->path_medium);
//        }
//
//        if($file->path_small){
//            Storage::delete($file->path_small);
//        }
//
//        $file->delete();
//    }
//
//    $db_files = File::all()->pluck('path')->toArray();
//
//    $storage_files = array_merge(Storage::allFiles('/public/2018'), Storage::allFiles('/public/2019'));
//
//    echo 'Db files - ' . count($db_files) . '<br/>';
//
//    echo 'Storage files - ' . count($storage_files);
//
//    foreach($storage_files as $file){
//        if( ! in_array(str_replace(['-medium', '-small'], '', $file), $db_files)){
//            Storage::delete($file);
//        }
//    }
//
//});

//Route::get('admin/space', function(){
//    $db_files = File::all();
//
//    $db_files_total = 0;
//
//    $empty = 0;
//
//    foreach($db_files as $file){
//
//        $db_files_total += 1;
//
//        if($file->path_medium){
//            $db_files_total += 1;
//        }
//
//        if($file->path_small){
//            $db_files_total += 1;
//        }
//
//        if( ! Storage::exists($file->path)){
//            echo $file->filable . '<br />';
//            echo $file->path . '<br / >';
//        }
//    }
//
//    $storage_files = array_merge(Storage::allFiles('/public/2018'), Storage::allFiles('/public/2019'));
//
//    dd('Db files total - ' . $db_files_total, 'Storage files total - ' . count($storage_files));
//
//});

Route::post('upload-image',
    [
        'as' => 'upload-image',
        'uses' =>  function(Request $request, Factory $validator) {
            $v = $validator->make($request->all(), [
                'upload' => 'required',
            ]);

            $funcNum = $request->input('CKEditorFuncNum');

            if ($v->fails()) {
                return response([
                    'message' => 'something went wrong'
                ]);
            }

            $image = $request->file('upload');
            $image->store('public/uploads');
            $url = asset('storage/uploads/'.$image->hashName());

            return response()->json([
                'uploaded' => 1,
                'fileName' => $image->hashName(),
                'url' => $url
            ]);
        }
    ]
);

Route::get('test/role', function(){
    $user = User::where('id', 17)->with('roles')->first();

    dd($user->toArray(), $user->hasRole('admin'));
});

# https://laravel.com/docs/8.x/csrf
Route::get('refresh-csrf',
    [
        'as'        => 'get-csrf',
        'uses'      =>
                        function(){
                            return csrf_token();
                        },
    ]
);
