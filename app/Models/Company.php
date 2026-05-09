<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{User,ShortUrl};

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

    public function shortUrls(){
        return $this->hasMany(ShortUrl::class);
    }

}
