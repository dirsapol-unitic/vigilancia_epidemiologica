<?php

namespace App\Models;

use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable, ShinobiTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','grado','dni',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function establecimientos(){

        return $this->belongsToMany('App\Models\Establecimiento');
    }

    public function grados(){

        return $this->belongsToMany('App\Models\Grado');
    }

    public function getUsers(){
        
        $cad="select id, name from users where rol!=1";
        $data = DB::select($cad);

        return $data;
    }
}
