<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class UserEducation extends Model
{
	use SoftDeletes;

	public function scopeActive($query)
    {
        return $query->whereStatus(STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->whereStatus(STATUS_INACTIVE);
    }
}