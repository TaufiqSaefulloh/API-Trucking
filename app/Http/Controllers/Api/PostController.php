<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Sopir;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function index()
    {
        //get posts
        $sopir = Sopir::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Sopir', $sopir);
    }
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'id_sopir' => 'required',
            'nama_sopir' => 'required',
            'email' => 'required|string|email|max:255|unique:sopir,email', // Validasi email unik
            'password' => 'required|string|min:8',
            'pdf_file' => 'nullable|mimes:pdf|max:2048'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $sopir = Sopir::create([
            // 'image'     => $image->hashName(),
            'id_sopir'     => $request->id_sopir,
            'nama_sopir'   => $request->nama_sopir,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //return response
        return new PostResource(true, 'Data Sopir Berhasil Ditambahkan!', $sopir);
    }
    public function show(Sopir $sopir)
    {
        //return single post as a resource
        return new PostResource(true, 'Data Sopir Ditemukan!', $sopir);
    }
    public function update(Request $request, Sopir $sopir)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'id_sopir' => 'required',
            'nama_sopir' => 'required',
            'email' => 'required|string|email|max:255|unique:sopirs,email',
            'password' => 'required|string|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update post without image
        $sopir->update([
            'id_sopir' => $request->id_sopir,
            'nama_sopir' => $request->nama_sopir,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $sopir);
    }
    public function destroy(Sopir $sopir)
    {

        //delete post
        $sopir->delete();

        //return response
        return new PostResource(true, 'Data Sopir Berhasil Dihapus!', null);
    }
}
