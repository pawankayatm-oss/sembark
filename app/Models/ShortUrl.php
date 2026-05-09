<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{User,Company};
class ShortUrl extends Model
{
    //
    protected $table = 'short_urls';

    protected $fillable = [
        'company_id',
        'user_id',
        'original_url',
        'short_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
