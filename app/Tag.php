<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
	use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','status',
        //,'category_id'
    ];
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
	
	public static $rules = [
    	'title' => 'sometimes|required|unique:tags,title',
	];
	
	public function category(){
		return $this->belongsToMany('App\Category','tag_category');
	}
	
	//Tag model
	public function article()
	{
	    return $this->belongsToMany('Article','article_tags');
	}
}
