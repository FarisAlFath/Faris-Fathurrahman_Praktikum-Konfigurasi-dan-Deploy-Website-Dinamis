<?php

Route::get('/testing-cicd', function () {
    return '<div style="background-color: blue; padding: 50px; text-align: center;">
                <h1 style="color: red; font-size: 40px; font-weight: bold;">
                     DEPLOY OTOMATIS CI/CD ALFAJAR SUKSES Rekkk!
                </h1>
            </div>';
});
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


require __DIR__ . '/front.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
