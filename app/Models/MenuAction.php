<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuAction extends Model
{
    use Uuid, SoftDeletes;

    protected $table = 'menu_actions';
    public $incrementing = false;
    public $timestamps = true;
    protected $keytype = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'menu_id',
        'action_id',
        'created_by',
        'updated_by'
    ];

    public function menus()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function actions()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }

    public function rolePrivileges()
    {
        return $this->hasMany(RolePrivileges::class);
    }
}
