<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House_history extends Model
{
    use HasFactory;

    protected $table = 'house_histories';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
