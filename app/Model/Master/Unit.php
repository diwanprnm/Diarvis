<?php

namespace App\Model\Master;


use Illuminate\Database\Eloquent\Model;
use App\Model\Master\Bidang;
class Unit extends Model
{
    protected $table = "ref_organisasi_unit";

    public $timestamps = true;

        
    public function bidang() {
       return $this->hasMany(Bidang::class,'kode_bidang','kode_bidang');
        //return $this->belongsTo('App\Model\Master\Bidang', 'kode_bidang','kode_bidang');
    }
   
}
