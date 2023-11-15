<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use Uuid, SoftDeletes;

    protected $table = 'menus';
    public $incrementing = false;
    public $timestamps = true;
    protected $keytype = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'name',
        'icon',
        'url',
        'parent_id',
        'created_by',
        'updated_by',
    ];

    public function menuAction()
    {
        return $this->hasMany(MenuAction::class, 'menu_id');
    }
}
