<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function authors() {
        return $this->belongsToMany(Author::class, 'book_author');
    }
    
    public function genres() {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }
    
    public function publisher() {
        return $this->belongsTo(Publisher::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    
}
