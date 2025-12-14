<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'location', 
        'contact_person', 
        'phone'
    ];

    /**
     * একটি Depo-এর সাথে যুক্ত User-দের সম্পর্ক।
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}