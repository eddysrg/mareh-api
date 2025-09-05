<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimulatorRequest;
use App\Models\Simulator;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class SimulatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SimulatorRequest $request)
    {
        try {
            //Rate limiting adicional por IP
            $key = "credit-simulation:" . $request->ip();

            if(RateLimiter::tooManyAttempts($key, 5)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Demasiados intentos. Intenta nuevamente en unos minutos.',
                    'retry_after' => RateLimiter::availableIn($key)
                ], 429);
            }

            RateLimiter::hit($key, 60);

            $validatedData = $request->validated();

            Simulator::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Datos para simulador registrados con éxito',
                'status' => 'ok',
                'data' => $validatedData
            ]);


        } catch(\Exception $e) {
            Log::error('Credit simulator error', [
                'ip' => $request->ip(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor. Intenta nuevamente.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Simulator $simulator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Simulator $simulator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Simulator $simulator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Simulator $simulator)
    {
        //
    }
}
