<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionUser extends Model
{
    use HasFactory;

    protected $table = "permission_user";

    protected $fillable = [
        'permission_id',
        'user_id'
    ];


    //Mutators para cambiar la zona horaria del los timestamp
    public function setCreateAtAttribute($value) {
        date_default_timezone_set("America/Lima");//definimos sona horaria
        $this->attributes["created_at"] = Carbon::now(); //clase en laravel que nos permite manejar fechas
    }

    public function setUpdateAtAttribute($value) {
        date_default_timezone_set("America/Lima");//definimos sona horaria
        $this->attributes["updated_at"] = Carbon::now();
    }

    // Relacion
    public function permission()  {
        return $this->belongsTo(Permission::class);
    }

    // Relacion
    public function user()  {
        return $this->belongsTo(User::class);
    }
}
