<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters)
    {
        if ($filters) {
            $tag = request()->input('tag');

            if ($tag) {
                $query->where('tags', 'like', '%' . $tag . '%');
            }
        }
    }

}
