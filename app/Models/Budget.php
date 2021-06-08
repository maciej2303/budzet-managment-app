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

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function allCategories()
    {
        $defaultCategories = Category::where('default', 1)->get();
        return $defaultCategories->merge($this->categories);
    }

    public function isThresholdExceeded()
    {
        $expenses = $this->operations()->whereMonth('created_at', '=', now()->month)->where('income', false)->get()->sum('value');

        if ($this->threshold > 0 && $this->threshold + $expenses < 0)
            return true;

        return false;
    }
}
