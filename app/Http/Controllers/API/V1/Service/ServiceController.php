<?php

namespace App\Http\Controllers\API\V1\Service;

use App\Domain\Businesses\Models\Business;
use App\Domain\Services\Actions\CreateServiceAction;
use App\Domain\Services\DTOs\ServiceData;
use App\Domain\Services\Requests\StoreServiceRequest;
use App\Domain\Services\Resources\ServiceResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function index(Business $business)
    {
        return ServiceResource::collection(
            $business->services()
                ->where('is_active', true)
                ->latest()
                ->paginate()
        );
    }

    public function store(
        StoreServiceRequest $request,
        CreateServiceAction $action
    ): JsonResponse {

        $business = Business::findOrFail(
            $request->business_id
        );

        $service = $action->handle(
            ServiceData::fromRequest($request),
            $business->id
        );

        return response()->json([
            'message' => 'Service created successfully',
            'data' => new ServiceResource($service),
        ], 201);
    }

}
