<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Master\OfficeController;
use App\Http\Controllers\Other\FaqCategoryController;
use App\Http\Controllers\Other\FaqController;
use App\Http\Controllers\Suspect\SuspectController;
use App\Http\Controllers\Sys\ModuleController;
use App\Http\Controllers\Sys\RoleController;
use App\Http\Controllers\Sys\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json([
        'error' => true,
        'message' => 'API Not Found'], 404);
});

Route::get('/', function () {
    echo 'This is IDFACE API';
});

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [ForgotPasswordController::class,'sendResetLinkEmail']);
    Route::post('reset-password', [ResetPasswordController::class,'reset']);
    Route::post('email/verify', [VerificationController::class,'verify']);
    Route::post('email/resend',  [VerificationController::class,'resend']);
});

Route::group(['middleware' => 'auth.jwt'], function ($router) {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });



    $router->group(['prefix' => 'sys'], function ($router) {
        $router->group(['prefix' => 'users'], function ($router) {
            $router->get('/{id}', [UserController::class, 'show']);
            $router->post('/filter', [UserController::class, 'filter']);
            $router->post('/store', [UserController::class, 'store']);
            $router->put('/update/{id}', [UserController::class, 'update']);
            $router->put('/restore/{id}', [UserController::class, 'restore']);
            $router->delete('/{id}', [UserController::class, 'destroy']);
            $router->delete('/forceDelete/{id}', [UserController::class, 'forceDestroy']);
            $router->post('/exportPdf', [UserController::class, 'exportPdf']);
            $router->post('/exportExcel', [UserController::class, 'exportExcel']);
        });

        $router->group(['prefix' => 'modules'], function ($router) {
            $router->get('/{id}', [ModuleController::class, 'show']);
            $router->post('/filter', [ModuleController::class, 'filter']);
            $router->post('/store', [ModuleController::class, 'store']);
            $router->put('/update/{id}', [ModuleController::class, 'update']);
            $router->put('/restore/{id}', [ModuleController::class, 'restore']);
            $router->delete('/{id}', [ModuleController::class, 'destroy']);
            $router->delete('/forceDelete/{id}', [ModuleController::class, 'forceDestroy']);
        });

        $router->group(['prefix' => 'roles'], function ($router) {
            $router->get('/getModule', [ModuleController::class, 'getModulesPermissions']);
            $router->get('/all', [RoleController::class, 'all']);
            $router->get('/getRoleModulesPermissions/{role}', [RoleController::class, 'getRoleModulesPermissions']);
            $router->post('/filter', [RoleController::class, 'filter']);
            $router->get('/{role}', [RoleController::class, 'show']);
            $router->post('/store', [RoleController::class, 'store']);
            $router->put('/update/{role}', [RoleController::class, 'update']);
            $router->delete('/{id}', [RoleController::class, 'destroy']);
        });
    });

    $router->group(['prefix' => 'master'], function ($router) {
        $router->group(['prefix' => 'office'], function ($router) {
            $router->get('/count', [OfficeController::class, 'count']);
            $router->get('/{id}', [OfficeController::class, 'show']);
            $router->post('/filter', [OfficeController::class, 'filter']);
            $router->post('/store', [OfficeController::class, 'store']);
            $router->put('/update/{id}', [OfficeController::class, 'update']);
            $router->put('/restore/{id}', [OfficeController::class, 'restore']);
            $router->delete('/{id}', [OfficeController::class, 'destroy']);
            $router->delete('/forceDelete/{id}', [OfficeController::class, 'forceDestroy']);
            $router->post('/exportPdf', [OfficeController::class, 'exportPdf']);
            $router->post('/exportExcel', [OfficeController::class, 'exportExcel']);
        });
    });


    $router->group(['prefix' => 'other'], function ($router) {
        $router->group(['prefix' => 'faq-category'], function ($router) {
            $router->get('/count', [FaqCategoryController::class, 'count']);
            $router->get('/{id}', [FaqCategoryController::class, 'show']);
            $router->post('/store', [FaqCategoryController::class, 'store']);
            $router->put('/update/{id}', [FaqCategoryController::class, 'update']);
            $router->put('/restore/{id}', [FaqCategoryController::class, 'restore']);
            $router->delete('/{id}', [FaqCategoryController::class, 'destroy']);
            $router->delete('/forceDelete/{id}', [FaqCategoryController::class, 'forceDestroy']);
        });

        $router->group(['prefix' => 'faq'], function ($router) {
            $router->get('/count', [FaqController::class, 'count']);
            $router->get('/{id}', [FaqController::class, 'show']);
            $router->post('/store', [FaqController::class, 'store']);
            $router->put('/update/{id}', [FaqController::class, 'update']);
            $router->put('/restore/{id}', [FaqController::class, 'restore']);
            $router->delete('/{id}', [FaqController::class, 'destroy']);
            $router->delete('/forceDelete/{id}', [FaqController::class, 'forceDestroy']);
        });
    });

    $router->group(['prefix' => 'ws'], function ($router) {
        $router->group(['prefix' => 'ws'], function ($router) {
            $router->post('/filter', [SuspectController::class, 'filter']);
            $router->get('/count', [SuspectController::class, 'count']);
            $router->get('/{id}', [SuspectController::class, 'show']);
            $router->post('/store', [SuspectController::class, 'store']);
            $router->put('/update/{id}', [SuspectController::class, 'update']);
            $router->put('/restore/{id}', [SuspectController::class, 'restore']);
            $router->delete('/{id}', [SuspectController::class, 'destroy']);
            $router->delete('/forceDelete/{id}', [SuspectController::class, 'forceDestroy']);
            $router->post('/export/{id}', [SuspectController::class, 'exportPdfOne']);
        });
    });

});

Route::group(['prefix' => 'other'], function ($router) {
    $router->group(['prefix' => 'faq-category'], function ($router) {
        $router->post('/filter', [FaqCategoryController::class, 'filter']);
    });

    $router->group(['prefix' => 'faq'], function ($router) {
        $router->post('/filter', [FaqController::class, 'filter']);
    });
});
