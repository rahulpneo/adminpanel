<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profile';
	protected $fillable = [
        'user_id','profile_image','about_me'
    ];
	
	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
