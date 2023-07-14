<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','name', 'isPrivate'];

    public function criterias() : HasMany {
        return $this->hasMany(Criteria::class);
    }

    public function alternatives() : HasMany {
        return $this->hasMany(Alternative::class);
    }

    function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
