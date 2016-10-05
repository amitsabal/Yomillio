<?php
//use Illuminate\Database\Eloquent\SoftDeletes;
class ForumAnswer extends Model
{
	//use SoftDeletes;

    //protected $dates = ['deleted_at'];
    
    public function forum()
    {
        return $this->belongsTo('Forum', 'forum_id', 'id');
    }
    
    public function author()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }
}