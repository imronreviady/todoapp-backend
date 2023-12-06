<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Todo extends Model
{
    use HasFactory;

    protected $table = "todos";
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'is_done',
        'is_fav',
        'is_trash',
        'category',
    ];

    // protected $casts = [
    //     'tags' => 'array',
    // ];
    protected function category(): Attribute
    {

        return Attribute::make(

            get: fn ($value) => json_decode($value, true),

            set: fn ($value) => json_encode($value),

        );

    } 

    // is_done is_fav is_trash true or false
    protected $casts = [
        'is_done' => 'boolean',
        'is_fav' => 'boolean',
        'is_trash' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
