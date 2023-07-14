<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlternativeValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['criteria_id', 'alternative_id' ,'value'];

    public function criteria() : BelongsTo {
        return $this->belongsTo(Criteria::class);
    }

    public function alternative() : BelongsTo {
        return $this->belongsTo(Alternative::class);
    }
}
