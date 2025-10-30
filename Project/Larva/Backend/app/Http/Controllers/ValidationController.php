<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Validation;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'job' => 'required',
                'job_description' => 'required',
                'income' => 'required',
                'reason_accepted' => 'required'
            ]);

            $society = $request->user();

            // Cek apakah sudah pernah request validation
            $existingValidation = Validation::where('society_id', $society->id)->first();
            
            if ($existingValidation) {
                return response()->json([
                    'message' => 'You have already requested data validation'
                ], 400);
            }

            // Buat validation baru
            Validation::create([
                'society_id' => $society->id,
                'job' => $request->job,
                'job_description' => $request->job_description,
                'income' => $request->income,
                'reason_accepted' => $request->reason_accepted,
                'status' => 'pending'
            ]);

            return response()->json([
                'message' => 'Request data validation sent successful'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }
    }

    public function index(Request $request)
    {
        try {
            $society = $request->user();
            
            $validation = Validation::where('society_id', $society->id)
                ->with('validator')
                ->first();

            if (!$validation) {
                return response()->json([
                    'validation' => null
                ], 200);
            }

            return response()->json([
                'validation' => [
                    'id' => $validation->id,
                    'status' => $validation->status,
                    'job' => $validation->job,
                    'job_description' => $validation->job_description,
                    'income' => $validation->income,
                    'reason_accepted' => $validation->reason_accepted,
                    'validator_notes' => $validation->validator_notes,
                    'validator' => $validation->validator ? [
                        'id' => $validation->validator->id,
                        'name' => $validation->validator->name
                    ] : null
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }
    }
}