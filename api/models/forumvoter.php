<?php
//use Illuminate\Database\Eloquent\SoftDeletes;
class ForumVoter extends Model
{
	//use SoftDeletes;

    //protected $dates = ['deleted_at'];
    
    public function forum()
    {
        return $this->belongsTo('Forum', 'forum_id', 'id');
    }
    
    public function up_voter()
    {
        return $this->belongsTo('User', 'up_voter_id', 'id');
    }
    
    public function down_voter()
    {
        return $this->belongsTo('User', 'down_voter_id', 'id');
    }
}