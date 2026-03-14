<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display the list of customers belonging to the authenticated user.
     */
    public function index(): Response
    {
        $customers = auth()->user()
            ->customers()
            ->latest()
            ->get(['id', 'first_name', 'last_name', 'email', 'phone', 'company', 'created_at']);

        return Inertia::render('Dashboard', [
            'customers' => $customers,
        ]);
    }

    /**
     * Store a newly created customer for the authenticated user.
     */
    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        auth()->user()->customers()->create($request->validated());

        return redirect()->route('dashboard')->with('success', 'Customer created successfully.');
    }
}
