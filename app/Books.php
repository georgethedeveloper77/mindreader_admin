<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $table = 'books';

    protected $fillable = ['type','title','image','url'];
 
	
    public $timestamps = false;

	public static function getBookInfo($id,$field_name) 
    { 
		$info = Books::where('id',$id)->first();
		
		if($info)
		{
			return  $info->$field_name;
		}
		else
		{
			return  '';
		}
	}	 
 
}
