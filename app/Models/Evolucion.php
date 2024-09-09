<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Evolucion extends Model
{
    
	function getEvolucion($dni, $idficha){
        $cad = "select a.*
                from evolucions a
                where a.estado=1 and a.dni = '".$dni."' and a.idficha = '".$idficha."' ";
        $data = DB::select($cad);
        
        return $data;
    }  

    
}
