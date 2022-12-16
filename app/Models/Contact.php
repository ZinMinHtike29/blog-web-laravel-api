<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'message'];
    protected $appends = ["date"];

    public function getDateAttribute()
    {
        $d = new Carbon($this->created_at);
        return $d->diffForHumans();
    }
}