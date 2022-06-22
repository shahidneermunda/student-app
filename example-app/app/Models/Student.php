<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'country_id',
        'state_id',
        'image',
    ];

    //Country Model
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    //State Model
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
