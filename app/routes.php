<?php

Route::get('user/task/{id}/addsubtask', array('uses' => 'UserTaskController@getAddSubTask', 'as' => 'add-sub-task'));

Route::post('user/task/{id}/deletesubtask', array('uses' => 'UserTaskController@postDeleteSubTask', 'as' => 'delete-sub-task'));

Route::controller('user/task/{id}', 'UserTaskController');

Route::controller('user', 'UserController');

Route::get('/', array('uses' => 'HomeController@home', 'as' => 'home'));

Route::group(array('before' => 'auth'), function()
{
	Route::get('/user/logout', array('uses' => 'UserController@getLogout', 'as' => 'getLogout'));
});
