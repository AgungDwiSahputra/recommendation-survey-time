<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode', 'nama', 'parent_kode', 'tingkat'];

    public function parent()
    {
        return $this->belongsTo(Region::class, 'parent_kode', 'kode');
    }

    public function children()
    {
        return $this->hasMany(Region::class, 'parent_kode', 'kode');
    }
}