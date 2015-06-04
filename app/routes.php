<?php

Route::get('user/task/{id}/addsubtask', array('uses' => 'UserTaskController@getAddSubTask', 'as' => 'add-sub-task'));

Route::post('user/task/{id}/deletesubtask', array('uses' => 'UserTaskController@postDeleteSubTask', 'as' => 'delete-sub-task'));

Route::post('user/task/{id}/deletetask', array('uses' => 'UserTaskController@postDeleteTask', 'as' => 'delete-task'));

Route::post('user/task/{id}/assignmember', array('uses' => 'UserTaskController@postAssignMember', 'as' => 'assign-member'));

Route::post('user/task/{id}/postcomment', array('uses' => 'UserTaskController@postComment', 'as' => 'comment'));

Route::get('user/task/{id}/getchecklist/{cid}', array('uses' => 'ChecklistController@getChecklist', 'as' => 'checklist'));
Route::post('user/task/{id}/postchecklisttitle', array('uses' => 'ChecklistController@postChecklistTitle', 'as' => 'checklist-title'));
Route::post('user/task/{id}/postchecklistdata', array('uses' => 'ChecklistController@postChecklistData', 'as' => 'checklist-data'));
Route::post('user/task/{id}/postsubcheckdelete', array('uses' => 'ChecklistController@postSubCheckDelete', 'as' => 'subcheck-delete'));
Route::post('user/task/{id}/postcheckdelete', array('uses' => 'ChecklistController@postCheckDelete', 'as' => 'check-delete'));

Route::post('user/task/{id}/postfile', array('uses' => 'UserTaskController@postFile', 'as' => 'upload-file'));

Route::controller('user/task/{id}', 'UserTaskController');
Route::group(array('before' => 'auth'), function()
{
	Route::controller('user', 'UserController');

});


//Route::controller('user', array('before' => 'auth', 'uses' => 'UserController'));

Route::get('/', array('uses' => 'HomeController@home', 'as' => 'home'));

Route::group(array('before' => 'auth'), function()
{
	Route::get('/user/logout', array('uses' => 'UserController@getLogout', 'as' => 'getLogout'));
});
