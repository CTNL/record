<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;


class Record extends Model{
    //public $timestamps = false;
    protected $table = 'mesaj';
    const CREATED_AT = 'date';
    const UPDATED_AT = null;
    protected $fillable = ['sid','name','text','ip','active','deleted'];
}