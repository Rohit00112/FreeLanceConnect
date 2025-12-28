<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class payment extends Model
{
     protected $fillable = [
          'transaction_id',
          'paid_by',
          'paid_to',
          'post_project_id',
          'amount',
     ];

     public function freelancer() : BelongsTo
     {
          return $this->belongsTo(User::class, 'paid_to');
     }
     public function client() : BelongsTo
     {
          return $this->belongsTo(User::class, 'paid_by');
     }
     public function postProject() : BelongsTo
     {
          return $this->belongsTo(PostProject::class, 'post_project_id');
     }
}
