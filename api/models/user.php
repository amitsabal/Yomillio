<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function comments()
    {
        return $this->hasMany('Comment');
    }
	
	public function articles()
    {
        return $this->hasMany('Article', 'author_id', 'id');
    }
	
	public function forums()
    {
        return $this->hasMany('Forum');
    }

	public function scopeActive($query)
    {
        return $query->whereStatus(STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->whereStatus(STATUS_INACTIVE);
    }
}