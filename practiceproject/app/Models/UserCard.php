<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    // public function payment()
    // {
    //     return $this->hasMany(payment::class, 'user_cards_id', 'card_id');
    // }


}

