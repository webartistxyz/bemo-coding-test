<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['board_column_id', 'title', 'position', 'description'];

    public function column()
    {
        return $this->belongsTo(Column::class);
    }
}
