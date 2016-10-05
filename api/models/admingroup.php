<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class AdminGroup extends Model
{
	use SoftDeletes;
    
    protected $dates = ['deleted_at'];

	public function scopeActive($query)
    {
        return $query->whereStatus(STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->whereStatus(STATUS_INACTIVE);
    }
}