<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonalCustomerResource;
use App\Models\PersonalCustomer;
use Illuminate\Http\Request;

class PersonalCustomerController extends Controller
{
    public function index(Request $request)
    {
        // Infer user from token
        $user = $request->user();

        // Query filtering by user_id
        $customers = PersonalCustomer::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return PersonalCustomerResource::collection($customers);
    }

    public function show(PersonalCustomer $personalCustomer)
    {
        // Ensure authorization using Policy
        $this->authorize('view', $personalCustomer);

        return new PersonalCustomerResource($personalCustomer);
    }
}
