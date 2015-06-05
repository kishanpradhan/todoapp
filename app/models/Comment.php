<?php



class Comment extends Eloquent
{
	public function tasks()
    {
        return $this->belongsTo('Task');
    }	

}