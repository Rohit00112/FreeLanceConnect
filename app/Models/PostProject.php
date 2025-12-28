<?php

namespace App\Models;

use App\Enums\PostProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PostProject extends Model
{
    use HasFactory;

    protected $fillable = ['freelancer_id', 'client_id', 'project_name', 'project_description', 'budget', 'deadline', 'status'];

    public function freelancer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function client() : BelongsTo
{
    return $this->belongsTo(User::class, 'client_id');
}


     protected $casts = [
          'deadline' => 'date',
          'status' => PostProjectStatus::class
     ];
}

