<?php
use Illuminate\Database\Eloquent\SoftDeletes;
class UserSession extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'token';
}