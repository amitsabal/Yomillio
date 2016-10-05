<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class ForumCategory extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function articles()
    {
        return $this->hasMany('Article');
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