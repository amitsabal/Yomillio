<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class Article extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id')->select(['id','title']);
    }
    
    public function articletags()
    {
        return $this->hasMany('ArticleTag')->select(['id','article_id','tag_id']);
    }
	
	public function tags()
	{
		return $this->articletags()->select(['id','name']);
	}
    
    public function comments()
    {
        return $this->hasMany('Comment')->select(['id', 'comment', 'article_id', 'user_id', 'created_at', 'status']);
    }
    
    public function author()
    {
        return $this->belongsTo('User', 'author_id', 'id');
    }
	
	public function user()
    {
        return $this->belongsTo('User', 'author_id', 'id');
    }
    
    public function admin_author()
    {
        return $this->belongsTo('AdminUser', 'created_by', 'id');
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
    
    public function scopeCategory($query,$val)
    {
        return $query->where('category_id', '=', $val);
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }
    
    public function scopePublished($query)
    {
        return $query->where('status', '=', ARTICLE_STATUS_PUBLISH)
                    ->where('published_at', '<=', date('Y-m-d H:i:s'));
                    //->whereNotNull('thumbnail_image');
    }
}