<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\CategorieBook;


class Book extends Model
{
    use HasFactory;
    /**
     * Get the categories that belong to the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    
    
    protected $fillable = ['title', 'subtitle', 'livre'];

    public function categories()
    {
       return $this->belongsToMany(CategorieBook::class, 'books_categories', 'book_id', 'categorie_id');
    }

}
