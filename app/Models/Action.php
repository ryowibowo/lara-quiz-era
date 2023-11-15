<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class Action extends Model
{
    use Uuid;
    use SoftDeletes;

    protected $table = 'actions';
    public $incrementing = false;
    public $timestamps = true;
    protected $keytype = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'name',
        'desc',
        'created_by',
        'updated_by',
    ];

    public function menuAction()
    {
        return $this->hasMany(MenuAction::class, 'action_id');
    }
}
