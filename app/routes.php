<?php
Route::group(array('before' => 'auth'), function()
{
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

Route::post('user/task/{id}/postdeletecomment', array('uses' => 'UserTaskController@postDeleteComment', 'as' => 'comment-delete'));

Route::post('user/task/{id}/postfile', array('uses' => 'UserTaskController@postFile', 'as' => 'upload-file'));

Route::post('user/task/{id}/postdeletemember', array('uses' => 'UserTaskController@postDeleteMember', 'as' => 'member-delete'));

Route::controller('user/task/{id}', 'UserTaskController');

	Route::controller('user', 'UserController');

});
	#-------For login and Registration------------------
	Route::get('login', array('before' => 'myfil', 'uses' => 'UserFirstController@getLogin'));
	Route::post('login', 'UserFirstController@postLogin');
	Route::post('create', 'UserFirstController@postCreate');
	Route::get('create', array('before' => 'myfil', 'uses' => 'UserFirstController@getCreate'));
	#-------------------------------------------------------
	Route::get('user', array('before' => 'auth', 'uses' => 'UserController@getIndex'));//Working

Route::get('/', array('uses' => 'HomeController@home', 'as' => 'home'));

Route::group(array('before' => 'auth'), function()
{
	Route::get('/user/logout', array('uses' => 'UserController@getLogout', 'as' => 'getLogout'));
});
#-------Testing------------------------------------------
Route::post('test/{id}', 'UserFirstController@postAjax');
Route::post('search/{id}', 'UserFirstController@postK');
Route::post('ajax/{id}', 'UserFirstController@getAjax');