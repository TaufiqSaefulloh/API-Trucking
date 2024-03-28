<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Struk extends Model
{
    protected $table = 'struk';
    protected $fillable = [
        'id_sopir', 'tanggal', 'url'
    ];

    // Method untuk mengambil data struk berdasarkan id supir
    public static function getBySupirId($supirId)
    {
        return static::where('id_sopir', $supirId)->get();
    }

    // Method untuk menyimpan data struk baru
    public static function store($data)
    {
        return static::create($data);
    }

    // Method untuk menghapus data struk berdasarkan id
    public static function deleteById($id)
    {
        return static::where('id', $id)->delete();
    }

    // Method untuk mengupdate data struk berdasarkan id
    public static function updateById($id, $data)
    {
        return static::where('id', $id)->update($data);
    }
}
