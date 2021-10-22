<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'currency',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getFormattedPriceAttribute()
    {
        return $this->currency . $this->price;
    }
}
