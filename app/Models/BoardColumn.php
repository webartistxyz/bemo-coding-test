<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardColumn extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'board_id', 'position'];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
