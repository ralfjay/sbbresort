<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_guest_infos extends Model
{
    
    protected $table 		= 'tbl_guest_infos';
	protected $primaryKey 	= "guest_id";
    public $timestamps 		= false;

}
