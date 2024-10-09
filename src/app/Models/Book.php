<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

//    public function updateCharacterCount()
//    {
//        $this->total_characters = $this->chapters->sum(function ($chapter) {
//            return strlen($chapter->content);
//        });
//        $this->save();
//    }
}
