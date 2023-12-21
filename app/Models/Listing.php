<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

//    protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description', 'tags'];

    public function scopeFilter($query, array $filters)
    {
        if ($filters) {
            $tag = request()->input('tag');
            $search = request()->input('search');
            if ($tag) {
                $query->where('tags', 'like', '%' . $tag . '%');
            }
            if ($search) {
                $query->where('title', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%')->orWhere('tags', 'like', '%' . $search . '%');
            }
        }
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
