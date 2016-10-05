<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class ArticleTag extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function article()
    {
        return $this->belongsTo('Article');
    }
    
    public function tags()
    {
        return $this->belongsTo('Tag', 'tag_id', 'id')->select(['name','id']);
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