<?php

namespace App\Model\Transactional;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "tr_log";
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
