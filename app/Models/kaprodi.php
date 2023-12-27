<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kaprodi extends Model
{
    use HasFactory;
    protected $fillable=[
        'name_k','nip','prodi','NOHP','id_u'
    ];
}
