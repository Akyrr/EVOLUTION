<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InstallmentApplySociety;
use App\Models\InstallmentApplyStatus;
use App\Models\Validation;
use App\Models\AvailableMonth;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'instalment_id' => 'required|integer|exists:installment,id',
                'months' => 'required|integer',
                'notes' => 'nullable|string'
            ]);

            $society = $request->user();

            // Cek apakah validation data sudah accepted
            $validation = Validation::where('society_id', $society->id)
                ->where('status', 'accepted')
                ->first();

            if (!$validation) {
                return response()->json([
                    'message' => 'Your data validator must be accepted by validator before'
                ], 401);
            }

            // Cek apakah sudah pernah apply
            $existingApplication = InstallmentApplySociety::where('society_id', $society->id)->first();
            
            if ($existingApplication) {
                return response()->json([
                    'message' => 'Application for a instalment can only be once'
                ], 401);
            }

            // Cari available month untuk installment dan months yang dipilih
            $availableMonth = AvailableMonth::where('installment_id', $validated['instalment_id'])
                ->where('month', $validated['months'])
                ->first();

            if (!$availableMonth) {
                return response()->json([
                    'message' => 'Selected months not available for this installment'
                ], 400);
            }

            // Buat application
            $application = InstallmentApplySociety::create([
                'society_id' => $society->id,
                'installment_id' => $validated['instalment_id'],
                'available_month_id' => $availableMonth->id,
                'notes' => $validated['notes'] ?? '',
                'date' => now()->toDateString()
            ]);

            // Buat status application
            InstallmentApplyStatus::create([
                'society_id' => $society->id,
                'installment_id' => $validated['instalment_id'],
                'available_month_id' => $availableMonth->id,
                'installment_apply_societies_id' => $application->id,
                'date' => now()->toDateString(),
                'status' => 'pending'
            ]);

            return response()->json([
                'message' => 'Applying for Instalment successful'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $e->errors()
            ], 401);
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

            $applications = InstallmentApplySociety::where('society_id', $society->id)
                ->with(['installment.brand', 'availableMonth', 'status'])
                ->get();

            $instalments = $applications->map(function ($application) {
                return [
                    'id' => $application->installment->id,
                    'car' => $application->installment->cars,
                    'brand' => $application->installment->brand ? $application->installment->brand->brand : '',
                    'price' => (string) $application->installment->price,
                    'description' => $application->installment->description,
                    'applications' => [
                        [
                            'month' => (string) $application->availableMonth->month,
                            'nominal' => (string) $application->availableMonth->nominal,
                            'apply_status' => $application->status ? $application->status->status : 'pending',
                            'notes' => $application->notes
                        ]
                    ]
                ];
            });

            return response()->json([
                'instalments' => $instalments
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }
    }
}

// Model tambahan yang diperlukan
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentApplySociety extends Model
{
    protected $table = 'installment_apply_societies';
    public $timestamps = false;
    
    protected $fillable = [
        'society_id',
        'installment_id',
        'available_month_id',
        'notes',
        'date'
    ];
    
    public function society()
    {
        return $this->belongsTo(Society::class);
    }
    
    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
    
    public function availableMonth()
    {
        return $this->belongsTo(AvailableMonth::class);
    }
    
    public function status()
    {
        return $this->hasOne(InstallmentApplyStatus::class, 'installment_apply_societies_id');
    }
}

class InstallmentApplyStatus extends Model
{
    protected $table = 'installment_apply_status';
    public $timestamps = false;
    
    protected $fillable = [
        'society_id',
        'installment_id', 
        'available_month_id',
        'installment_apply_societies_id',
        'date',
        'status'
    ];
    
    public function application()
    {
        return $this->belongsTo(InstallmentApplySociety::class, 'installment_apply_societies_id');
    }
}