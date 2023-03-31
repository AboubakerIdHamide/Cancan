<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable=["name", "description", "status","date_debut", "date_fin", "project_id"];

    public function project()
    {
        return $this->belongsTo(Project::class, "project_id", "id");
    }
}
