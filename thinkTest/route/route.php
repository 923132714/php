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
Route::get("/","index/index/index");

Route::group("admin", function () {
    Route::get("/login","admin/login/index");
    Route::post("/login","admin/login/login");
    Route::get("/logout","admin/login/logout");

    Route::get("/index/index", "admin/index/index");
    Route::get("/index/create", "admin/index/create");
    Route::post("/index/create", "admin/index/save");
    Route::get("/index/:id/delete", "admin/index/delete");
    Route::post("/index/:id/delete", "admin/index/delete");
    Route::get("/index/:id/edit", "admin/index/edit");
    Route::post("/index/:id/edit", "admin/index/update");
    Route::get("/index/read", "admin/index/read");
    Route::post("/index/read", "admin/index/read");

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
