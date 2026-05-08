<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\company;
class Invitation extends Model
{
    //
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'role',
        'token',
        'accept_status',
        'invited_by'
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
