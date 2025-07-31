<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Book;


class CategorieBook extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_categories', 'categorie_id', 'book_id');
    }
}
