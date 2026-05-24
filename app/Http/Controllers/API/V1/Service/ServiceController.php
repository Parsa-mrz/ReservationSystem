<?php

namespace App\Http\Controllers\API\V1\Service;

use App\Domain\Businesses\Models\Business;
use App\Domain\Services\Actions\CreateServiceAction;
use App\Domain\Services\DTOs\ServiceData;
use App\Domain\Services\Models\Service;
use App\Domain\Services\Requests\StoreServiceRequest;
use App\Domain\Services\Resources\ServiceResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        CreateServiceAction $action
    ): JsonResponse {


        $service = $action->handle(
            ServiceData::fromRequest($request),
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

    public function destroy(Service $service){
        $service->delete();
        return $this->success(data:[],message: 'Service deleted successfully',status: Response::HTTP_NO_CONTENT);
    }

}
