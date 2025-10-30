<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Models\InstallmentApplySociety;
use App\Models\Validation;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $installments = Installment::with(['brand', 'availableMonths'])->get();

            $cars = $installments->map(function ($installment) {
                return [
                    'id' => $installment->id,
                    'car' => $installment->cars,
                    'brand' => $installment->brand ? $installment->brand->brand : '',
                    'price' => (string) $installment->price,
                    'description' => $installment->description,
                    'available_month' => $installment->availableMonths->map(function ($month) {
                        return [
                            'month' => $month->month,
                            'description' => $month->description,
                        ];
                    })
                ];
            });

            return response()->json([
                'cars' => $cars
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $installment = Installment::with(['brand', 'availableMonths'])->find($id);

            if (!$installment) {
                return response()->json([
                    'message' => 'Installment not found'
                ], 404);
            }

            return response()->json([
                'instalment' => [
                    'id' => $installment->id,
                    'car' => $installment->cars,
                    'brand' => $installment->brand ? $installment->brand->brand : '',
                    'price' => (string) $installment->price,
                    'description' => $installment->description,
                    'available_month' => $installment->availableMonths->map(function ($month) {
                        return [
                            'month' => $month->month,
                            'description' => $month->description,
                        ];
                    })
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }
    }
}