<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::get("/", "index/index/index");



Route::group("admin", function () {

    Route::get("login", "admin/login/index");
    Route::post("login", "admin/login/login");
    Route::get("logout", "admin/login/logout");

    Route::group("permission", function () {
        Route::get("/index", "admin/permission/index");
        Route::get("/create", "admin/permission/create");
        Route::post("/create", "admin/permission/save");
        Route::get("/edit/:id", "admin/permission/edit");
        Route::post("/edit/:id", "admin/permission/update");
        Route::get("/delete/:id", "admin/permission/delete");
        Route::post("/delete/:id", "admin/permission/delete");
    });
    Route::group("role", function () {
        Route::get("/index", "admin/role/index");
        Route::get("/create", "admin/role/create");
        Route::post("/create", "admin/role/save");
        Route::get("/edit/:id", "admin/role/edit");
        Route::post("/edit/:id", "admin/role/update");
        Route::get("/delete/:id", "admin/role/delete");
        Route::post("/delete/:id", "admin/role/delete");
    });
    Route::group("index", function () {
    Route::get("/index", "admin/index/index");
    Route::get("/create", "admin/index/create");
    Route::post("/create", "admin/index/save");
    Route::get("/:id/delete", "admin/index/delete");
    Route::post("/:id/delete", "admin/index/delete");
    Route::get("/:id/edit", "admin/index/edit");
    Route::post("/:id/edit", "admin/index/update");
    Route::get("/read", "admin/index/read");
    Route::post("/read", "admin/index/read");
    Route::get("/batch_create", "admin/index/batchCreate");
    Route::post("/batch_create", "admin/index/batchSave");
    });

});



//
//Route::get('think', function () {
//    return 'hello,ThinkPHP5!';
//});
//
//Route::get('hello/:name', 'index/hello');
//
//return [
//
//];
