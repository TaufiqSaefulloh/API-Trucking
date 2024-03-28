<?php

namespace App\Http\Controllers\Api;

use App\Models\Sopir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'id_sopir' => 'required',
            'nama_sopir' => 'required',
            'email' => 'required|string|email|max:255|unique:sopirs,email',
            'password' => 'required|string|min:8',
            'pdf_file' => 'nullable|mimes:pdf|max:2048'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create sopirs
        $sopirs = Sopir::create([
            'id_sopir' => $request->id_sopir,
            'nama_sopir' => $request->nama_sopir,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //return response JSON sopirs is created
        if ($sopirs) {
            return response()->json([
                'success' => true,
                'sopirs'    => $sopirs,
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    // Method untuk hashing password
    public function hashPassword($password) {
        return Hash::make($password);
    }

    // Method untuk memeriksa login
    public function checkLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        // Mendapatkan data pengguna berdasarkan email
        $sopir = Sopir::where('email', $credentials['email'])->first();

        // Jika pengguna ditemukan
        if($sopir) {
            // Memeriksa apakah password cocok
            if(Hash::check($credentials['password'], $sopir->password)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'sopir' => $sopir
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah.'
                ], 401);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak ditemukan.'
            ], 404);
        }
    }
}
