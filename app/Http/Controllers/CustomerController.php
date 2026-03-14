<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
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
     * Display the full detail page of a single customer.
     * Scoped to the authenticated user to prevent unauthorized access.
     */
    public function show(Customer $customer): Response
    {
        abort_if($customer->user_id !== auth()->id(), 403);

        return Inertia::render('Customers/Show', [
            'customer' => $customer,
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

    /**
     * Delete a customer. Scoped to the authenticated user.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        abort_if($customer->user_id !== auth()->id(), 403);

        $customer->delete();

        return redirect()->route('dashboard')->with('success', 'Customer deleted successfully.');
    }

    /**
     * Update an existing customer. Scoped to the authenticated user to prevent
     * unauthorized access to other users' customers.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        // Ensure the customer belongs to the authenticated user
        abort_if($customer->user_id !== auth()->id(), 403);

        $customer->update($request->validated());

        return redirect()->route('dashboard')->with('success', 'Customer updated successfully.');
    }
}
