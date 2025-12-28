<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{

    protected $fillable = ['project_id', 'image'];

    // Relationship: A project image belongs to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

