<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormLocation extends Model
{
    use HasFactory;

    protected $fillable = ['form_id', 'location_name'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
