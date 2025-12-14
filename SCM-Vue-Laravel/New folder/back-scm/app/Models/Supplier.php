<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // কোন কোন ফিল্ড অ্যাসাইন করা যাবে (Create/Update-এর জন্য)
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
    ];
}