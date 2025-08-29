<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['user_id','amount','transaction_type','to_user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function toUser() {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
