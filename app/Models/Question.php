<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class Question extends Model
{
    use Uuid, SoftDeletes;

    protected $table = 'questions';
    public $incrementing = false;
    public $timestamps = true;
    protected $keytype = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'topic_id',
        'questions',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
        'answer',
        'created_by',
        'updated_by',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function getApiData()
    {
        $data = Question::select('questions', 'answer')->orderBy('updated_at', 'desc')->get();
        return $data;
    }
}
