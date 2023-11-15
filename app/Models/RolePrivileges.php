<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePrivileges extends Model
{
    use Uuid, SoftDeletes;

    protected $table = 'role_privileges';
    public $incrementing = false;
    public $timestamps = true;
    protected $keytype = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'role_id',
        'menuaction_id',
        'created_by',
        'updated_by'
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function menuActions()
    {
        return $this->belongsTo(MenuAction::class, 'menuaction_id');
    }
}
