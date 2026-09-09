<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Models\Medicine;
use App\Services\MedicineService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class MedicineController extends Controller
{
    protected MedicineService $medicineService;

    public function __construct(MedicineService $medicineService)
    {
        $this->medicineService = $medicineService;
    }

    public function index(): View
    {
        $medicines = $this->medicineService
            ->getAllPaginated();

        return view(
            'admin.medicines.index',
            compact('medicines')
        );
    }

    public function create(): View
    {
        return view('admin.medicines.create');
    }

    public function store(
        StoreMedicineRequest $request
    ): RedirectResponse {
        try {
            $this->medicineService->create(
                $request->validated()
            );

            return redirect()
                ->route('admin.medicines.index')
                ->with(
                    'success',
                    'Medicine created successfully.'
                );

        } catch (DomainException $exception) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $exception->getMessage()
                );

        } catch (Throwable $exception) {

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Medicine could not be created.'
                );
        }
    }

    public function edit(Medicine $medicine): View
    {
        return view(
            'admin.medicines.edit',
            compact('medicine')
        );
    }

    public function update(
        UpdateMedicineRequest $request,
        Medicine $medicine
    ): RedirectResponse {
        try {
            $this->medicineService->update(
                $medicine,
                $request->validated()
            );

            return redirect()
                ->route('admin.medicines.index')
                ->with(
                    'success',
                    'Medicine updated successfully.'
                );

        } catch (DomainException $exception) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $exception->getMessage()
                );

        } catch (Throwable $exception) {

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Medicine could not be updated.'
                );
        }
    }

    public function destroy(
        Medicine $medicine
    ): RedirectResponse {
        try {
            $this->medicineService->delete($medicine);

            return redirect()
                ->route('admin.medicines.index')
                ->with(
                    'success',
                    'Medicine deleted successfully.'
                );

        } catch (DomainException $exception) {

            return back()->with(
                'error',
                $exception->getMessage()
            );

        } catch (Throwable $exception) {

            report($exception);

            return back()->with(
                'error',
                'Medicine could not be deleted.'
            );
        }
    }
}
