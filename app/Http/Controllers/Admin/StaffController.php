<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Staff;
use App\Services\StaffService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class StaffController extends Controller
{
    protected StaffService $staffService;

    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    /**
     * Display all staff members.
     */
    public function index(): View
    {
        $staffMembers = $this->staffService
            ->getAllPaginated();

        return view(
            'admin.staff.index',
            compact('staffMembers')
        );
    }

    /**
     * Show the form for creating staff.
     */
    public function create(): View
    {
        return view('admin.staff.create');
    }

    /**
     * Store a new staff member.
     */
    public function store(
        StoreStaffRequest $request
    ): RedirectResponse {
        try {
            $this->staffService->create(
                $request->validated()
            );

            return redirect()
                ->route('admin.staff.index')
                ->with(
                    'success',
                    'Staff member created successfully.'
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
                    'Staff member could not be created.'
                );
        }
    }

    /**
     * Display one staff member.
     */
    public function show(Staff $staff): View
    {
        $staff->load('user');

        return view(
            'admin.staff.show',
            compact('staff')
        );
    }

    /**
     * Show the edit form.
     */
    public function edit(Staff $staff): View
    {
        $staff->load('user');

        return view(
            'admin.staff.edit',
            compact('staff')
        );
    }

    /**
     * Update a staff member.
     */
    public function update(
        UpdateStaffRequest $request,
        Staff $staff
    ): RedirectResponse {
        try {
            $this->staffService->update(
                $staff,
                $request->validated()
            );

            return redirect()
                ->route('admin.staff.show', $staff)
                ->with(
                    'success',
                    'Staff member updated successfully.'
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
                    'Staff member could not be updated.'
                );
        }
    }

    public function sendPasswordReset(Staff $staff): RedirectResponse
    {
        try {
            $this->staffService->sendPasswordSetupLink($staff);

            return redirect()
                ->route('admin.staff.show', $staff)
                ->with(
                    'success',
                    'Password setup/reset link has been sent successfully.'
                );
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.staff.show', $staff)
                ->with(
                    'error',
                    'Unable to send the password setup/reset link.'
                );
        }
    }
}//background ma run garnai, medicine sakiyo aaba notify hoss hunebitikai.
