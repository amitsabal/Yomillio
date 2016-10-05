<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class Forum extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function author()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }
    
    public function category()
    {
        return $this->belongsTo('ForumCategory', 'category_id', 'id');
    }
    
    public function answers()
    {
        return $this->hasMany('ForumAnswer');
    }
    
    public function voters()
    {
        return $this->hasMany('ForumVoter');
    }
    
    public function scopeActive($query)
    {
        return $query->whereStatus(STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->whereStatus(STATUS_INACTIVE);
    }
    
    public function scopePopular($query)
    {
        return $query->where('view_count', '>=', 0);
    }
	public function scopeUnpublished($query)
    {
        return $query->where('status', '=', FORUM_STATUS_UNPUBLISH);
    }
}