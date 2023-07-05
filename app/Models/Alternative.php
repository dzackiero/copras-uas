<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alternative extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','name'];

    public function alternative_values() : HasMany {
        return $this->hasMany(AlternativeValue::class);
    }

    public function project() : BelongsTo {
        return $this->belongsTo(Project::class);
    }
}
