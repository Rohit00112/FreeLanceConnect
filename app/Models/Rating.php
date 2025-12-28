<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',  // The client who gave the rating
        'freelancer_id',  // The freelancer who received the rating
        'rating',  // Rating value
        'review',  // Optional review
    ];

    // Relationship to the freelancer (who is being rated)
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    // Relationship to the client (who gives the rating)
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



}
