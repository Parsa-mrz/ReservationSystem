<?php

namespace App\Http\Controllers\API\V1\Service;

use App\Domain\Businesses\Models\Business;
use App\Domain\Services\Actions\Interfaces\CreatesService;
use App\Domain\Services\Models\Service;
use App\Domain\Services\Resources\ServiceResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Services\StoreServiceRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{

    public function index(Business $business)
    {
        $services =  ServiceResource::collection(
            $business->services()
                ->where('is_active', true)
                ->latest()
                ->paginate()
        );

        return $this->success(
            data:[
                'services' => $services
            ],
            message: 'Services fetched successfully'
        );
    }

    public function store(
        StoreServiceRequest $request,
        Business $business,
        CreatesService $action
    ): JsonResponse {


        $service = $action->handle(
            $request->toDTO(),
            $business->id
        );

        return $this->success(
            data:[
                'service' => ServiceResource::make($service)
            ],
            message: 'Service created successfully',
            status: Response::HTTP_CREATED
        );
    }

    public function destroy(Business $business, Service $service): JsonResponse{
        $service->delete();
        return $this->success(data:[],message: 'Service deleted successfully',status: Response::HTTP_NO_CONTENT);
    }

}
