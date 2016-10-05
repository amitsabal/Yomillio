<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class Comment extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function article()
    {
        return $this->belongsTo('Article', 'article_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
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