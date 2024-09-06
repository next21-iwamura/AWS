<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 論理削除を使用できるよう追記
use Illuminate\Database\Eloquent\SoftDeletes;

class Stuff_name extends Model
{
    use HasFactory;
// 論理削除を使用できるよう追記
    use softdeletes;

    /*// 20220426追記
    protected $fillable = [

        'first_name'

    ];*/
}
