<?php

class Task extends Eloquent{

	public function comments()
    {
        return $this->hasMany('Comment');
    }

}