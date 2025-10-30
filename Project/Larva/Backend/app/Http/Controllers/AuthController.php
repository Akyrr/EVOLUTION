<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'id_card_number' => 'required',
                'password' => 'required'
            ]);

            // Cari society berdasarkan ID card number
            $society = Society::where('id_card_number', $request->id_card_number)->first();

            // Check apakah society ada dan password benar
            if (!$society || $society->password !== $request->password) {
                return response()->json([
                    'message' => 'ID Card Number or Password incorrect'
                ], 401);
            }

            // Hapus token lama
            $society->tokens()->delete();

            // Buat token baru
            $token = $society->createToken('society-token')->plainTextToken;

            // Return response sesuai spesifikasi
            return response()->json([
                'name' => $society->name,
                'born_date' => $society->born_date,
                'gender' => $society->gender,
                'address' => $society->address,
                'token' => $token,
                'regional' => [
                    'id' => $society->regional->id,
                    'province' => $society->regional->province,
                    'district' => $society->regional->district
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ID Card Number or Password incorrect'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Hapus current token
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout success'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid token'
            ], 401);
        }
    }
}