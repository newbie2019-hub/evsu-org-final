<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    public $fillable = ['what', 'where', 'when', 'who', 'organization_id'];

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
