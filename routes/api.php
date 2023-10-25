<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::any('service-available', fn () => response('OK'));

Route::group(['middleware' => ['api', 'auth:admin'], 'prefix' => 'auth/admin', 'as' => 'auth.admin.'], function ($router) {
    Route::post('login', 'AuthAdminController@login')->withoutMiddleware('auth:admin');
    Route::post('logout', 'AuthAdminController@logout');
    Route::post('refresh', 'AuthAdminController@refresh');
    Route::get('me', 'AuthAdminController@userProfile');
});

Route::group(['middleware' => ['api', 'auth:user'], 'prefix' => 'auth/user', 'as' => 'auth.user.'], function ($router) {
    Route::post('login', 'AuthUserController@login')->withoutMiddleware('auth:user');
    Route::post('register', 'AuthUserController@register');
    Route::post('logout', 'AuthUserController@logout');
    Route::post('refresh', 'AuthUserController@refresh');
    Route::get('me', 'AuthUserController@userProfile');
    Route::post('me/update/avatar', 'AuthUserController@updateAvatar');
    Route::put('me/update/info', 'AuthUserController@updateInforamtion');
    Route::put('me/update/last/active', 'AuthUserController@updateLastActive');
});

Route::group(['middleware' => ['api', 'auth:admin'], 'prefix' => 'admin', 'as' => 'admins.'], function ($router) {
    Route::apiResources([
        'users' => 'UserController',
        'admins' => 'AdminController',
        'workspaces' => 'WorkspaceController',
    ]);

    Route::apiResource('roles', 'RoleController');

    Route::put('roles/{role}/permission', 'RoleController@assignPermissions')->name('roles.permission.assign');
    Route::put('admins/{admin}/roles', 'AdminController@assignRoleAdmin')->name('roles.assign');

    Route::apiResource('permissisions', 'PermissionController')->only(['index']);
});


Route::group(['middleware' => ['api', 'auth:user'], 'prefix' => 'workspaces', 'as' => 'workspaces.'], function ($router) {
    Route::post('workspaces/create/new', 'WorkspaceController@createNew')->name('workspace.create.new');
    Route::get('workspaces/my/workspaces', 'WorkspaceController@myWorkspaces')->name('workspace.my.workspaces');
    Route::put('workspaces/{workspace}/users/assign', 'WorkspaceController@assignUsers')->name('workspace.users.assign');

    route::post('workspaces/{workspace}/invitations/create', 'WorkspaceController@storeInvitations')->name('workspace.invitations.store');
    Route::get('workspaces/{workspace}/invitations/{inviteWorkspace}', 'WorkspaceController@getInvitation')->name('workspace.invitations.show')->withoutMiddleware('auth:user');
    Route::put('workspaces/{workspace}/invitations/{inviteWorkspace}/accept', 'WorkspaceController@acceptInvitation')->name('workspace.invitations.accept')->withoutMiddleware('auth:user');
});

Route::group(['middleware' => ['api', 'auth:user'], 'prefix' => 'w/{workspace}', 'as' => 'workspace.'], function ($router) {

    Route::get('permissisions', 'PermissionController@index')->name('permissisions.index');
    Route::put('permissisions/sync/user/{user}', 'PermissionController@syncPermissionsUser')->name('permissisions.sync.users');
    Route::get('permissisions/list/user/{user}', 'PermissionController@listPermissionsUser')->name('permissisions.list.users');
    Route::get('permissisions/my/list', 'PermissionController@myPermissionsUser')->name('permissisions.my.list');

    Route::get('projects/my/owner', 'ProjectController@myProjects')->name('projects.my.projects');
    Route::put('projects/{project}/toggle/active', 'ProjectController@toggleActive')->name('projects.toggle.active');
    Route::put('projects/{project}/make/archived', 'ProjectController@makeArchive')->name('projects.make.archived');
    Route::apiResource('projects', 'ProjectController');

    // Group statuses of workspace
    Route::apiResource('statuses', 'StatusController');

    // Group Tasks of workspace
    Route::get('tasks', 'TaskController@index')->name('tasks.index.workspace');

    // Group contents of project
    Route::group(['middleware' => ['project.group'], 'prefix' => 'project/{project}', 'as' => 'project.'], function ($router) {

        // Tasks by project
        Route::apiResource('tasks', 'TaskController');

        // Group contents of task
        Route::group(['middleware' => ['project.task.group'], 'prefix' => 'tasks/{task}', 'as' => 'tasks.'], function ($router) {

            Route::put('status/{status}/change', 'TaskController@changeStatusTask')->name('status.change.task');
            Route::put('status/{status}/change/user/{task_user}', 'TaskController@changeStatusTaskUser')->name('status.change.task.user');

            Route::post('add/attachment', 'TaskController@addAttachment')->name('add.attachment');
            Route::delete('delete/attachment/{media}', 'TaskController@deleteAttachment')->name('delete.attachment');

            Route::post('assign/user/{user}', 'TaskController@assignUser')->name('assign.user');
            Route::post('comment', 'TaskController@addComment')->name('comment.add');
            Route::put('comment/{comment}', 'TaskController@updateComment')->name('comment.update');
            Route::delete('comment/{comment}', 'TaskController@deleteComment')->name('comment.delete');
            Route::post('comment/{comment}/add/media', 'TaskController@addMediaComment')->name('comment.add.media');
            Route::delete('comment/{comment}/{media}', 'TaskController@deleteMediaComment')->name('comment.delete.media');
        });
    });
});
