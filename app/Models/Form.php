<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'request_date', 'status', 'guest_salutation', 'guest_name', 'guest_house_number', 'guest_village', 'location_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(FormAttachment::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function locations()
    {
        return $this->hasMany(FormLocation::class);
    }
}
