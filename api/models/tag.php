<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class Tag extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function articles()
    {
        return $this->hasMany('Article');
    }
    
    public function articletag()
    {
        return $this->hasMany('ArticleTag');
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