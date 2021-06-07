<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['creator_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function isThresholdExceeded()
    {
        $expenses = $this->operations()->whereMonth('created_at', '=', now()->month)->where('income', false)->get()->sum('value');

        if ($this->threshold + $expenses < 0)
            return true;

        return false;
    }
}
