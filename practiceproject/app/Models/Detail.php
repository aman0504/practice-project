<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\PracticeController;

class Detail extends Model
{
    use HasFactory;

protected $fillable = [
 'name', 'email', 'code'
];
}
