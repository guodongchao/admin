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

Route::any('/adminLogin','Admin\AdminController@adminLogin');//后台登陆
/*中间件组->验证登陆*/
Route::group(['middleware' => 'login'],function($route){
Route::get('/','Admin\AdminController@adminLogin');
Route::get('/admin','Admin\AdminController@admin');//后台首页
Route::any('/adminquit','Admin\AdminController@adminQuit');//后台退出
Route::post('/verify','Admin\AdminController@verify');//验证用户
/*文件上传*/
Route::any('/upload','Upload\UploadController@uploadAdd');//单文件上传
/*权限部分*/
Route::any('/access','Rbac\RbacController@rbacShow');//权限管理
Route::any('/accessadd','Rbac\RbacController@rbacAdd');//权限添加、修改
/*角色部分*/
Route::any('/roleadd','Rbac\RbacController@roleAdd');//角色添加、修改
Route::post('/roledel','Rbac\RbacController@roleDel');//角色删除
/*用户部分*/
Route::any('/useradd','Rbac\RbacController@userAdd');//用户添加、修改
Route::post('/userdel','Rbac\RbacController@userDel');//用户删除
Route::post('/userup','Rbac\RbacController@userUp');//用户、角色、权限、修改(及点击改)
/*单位部分*/
Route::any('/site','Site\SiteController@siteShow');//单位管理
Route::post('/siteadd','Site\SiteController@siteAdd');//单位添加、修改
Route::post('/sitedel','Site\SiteController@siteDel');//单位删除
Route::any('/siteup','Site\SiteController@siteUp');//单位修改(及点击改)
/*设备部分*/
Route::any('/facility','Facility\FacilityController@facilityShow');//设备管理
Route::post('/facilityadd','Facility\FacilityController@facilityAdd');//设备添加、修改
Route::post('/facilitydel','Facility\FacilityController@facilitydel');//设备删除
Route::any('/facilityup','Facility\FacilityController@facilityup');//设备修改(及点击改)
/*中间件组->验证权限*/
Route::group(['middleware' => 'access'],function($route){
/*模块部分*/
Route::any('/module','Module\ModuleController@moduleShow');//模块管理
Route::post('/moduleadd','Module\ModuleController@moduleAdd');//模块添加、修改
Route::post('/moduledel','Module\ModuleController@moduleDel');//模块删除
Route::any('/moduleup','Module\ModuleController@moduleUp');//模块修改(及点击改)
Route::any('/moduleson','Moduleson\ModulesonController@modulesonShow');//模块内容管理
});
/*模块内容部分*/
Route::post('/modulesonadd','Moduleson\ModulesonController@modulesonAdd');//模块内容添加、修改
Route::post('/modulesondel','Moduleson\ModulesonController@modulesonDel');//模块内容删除
Route::post('/modulesonup','Moduleson\ModulesonController@modulesonUp');//模块内容修改(及点击改)
/*apk部分*/
Route::any('/apk','Apk\ApkController@apkShow');//apk管理
Route::post('/apkadd','Apk\ApkController@apkAdd');//apk添加、修改
Route::post('/apkdel','Apk\ApkController@apkDel');//apk删除
Route::post('/apkup','Apk\ApkController@apkUp');//apk修改(及点击改)
});
/*接口部分*/
Route::post('/api/facility','Api\FacilityController@facilityShow');//设备接口
Route::post('/api/apk','Api\apkController@apkShow');//apk接口
Route::post('/api/module','Api\ModuleController@moduleShow');//模块接口
