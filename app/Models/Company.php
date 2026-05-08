<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Company extends Model
{
    //
    protected $table = 'companies';
    protected $fillable = [
        'name',
        'company_website_url'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
