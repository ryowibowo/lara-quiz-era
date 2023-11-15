<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class ResultDetail extends Model
{
    use Uuid, SoftDeletes;

    protected $table = 'result_details';
    public $incrementing = false;
    public $timestamps = true;
    protected $keytype = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'questions_id',
        'result_id',
        'answer',
        'is_correct',
        'created_by',
        'updated_by',
    ];

    public function result()
    {
        return $this->belongsTo(Result::class);
    }
}
