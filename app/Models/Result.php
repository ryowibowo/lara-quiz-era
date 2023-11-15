<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class Result extends Model
{
    use Uuid, SoftDeletes;

    protected $table = 'results';
    public $incrementing = false;
    public $timestamps = true;
    protected $keytype = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'topic_id',
        'user_id',
        'start_time',
        'end_time',
        'timeout',
        'total_score',
        'created_by',
        'updated_by',
    ];

    public function resultDetail()
    {
        return $this->belongsTo(ResultDetail::class);
    }
}
