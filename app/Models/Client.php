<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address'];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function messages() {
        return $this->hasMany(ChatMessage::class, 'receiver_id');
    }
}
