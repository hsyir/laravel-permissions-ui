<?php

use Illuminate\Support\Facades\Route;

Route::resource("permissions","PermissionController");
Route::resource("roles","RoleController");
Route::post("roles/{role}/syncPermissions","RoleController@syncPermissions")->name("roles.syncPermissions");
Route::post("roles/{role}/addUser","RoleController@addUser")->name("roles.addUser");
Route::delete("roles/{role}/removeUser","RoleController@removeUser")->name("roles.removeUser");