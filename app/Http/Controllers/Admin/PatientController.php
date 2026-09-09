<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\View\View;

class PatientController extends Controller
{
    /**
     * Display all patients.
     */
    public function index(): View
    {
        $patients = Patient::query()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view(
            'admin.patients.index',
            compact('patients')
        );
    }

    /**
     * Display one patient.
     */
    public function show(Patient $patient): View
    {
        $patient->load([
            'user',
            'orders',
            'prescriptions',
        ]);

        return view(
            'admin.patients.show',
            compact('patient')
        );
    }
}
