<?php

namespace App\Http\Controllers\API\V1\Business;

use App\Domain\Businesses\Actions\CreateBusinessAction;
use App\Domain\Businesses\DTOs\BusinessData;
use App\Domain\Businesses\Models\Business;
use App\Domain\Businesses\Requests\StoreBusinessRequest;
use App\Domain\Businesses\Resources\BusinessResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessController extends Controller
{
    public function index(Request $request):JsonResponse{
        $businesses = Business::query()->latest()->paginate();

        return $this->success(
            data:[
                'businesses' => BusinessResource::collection($businesses),
            ]
        );
    }

    public function store(StoreBusinessRequest $request,CreateBusinessAction $action):JsonResponse
    {
        $business = $action->handle(
            BusinessData::fromRequest($request),
            $request->user()
        );


        return $this->success(
            data:[
                'business' => BusinessResource::make($business),
            ],
            message: 'Business created successfully',
            status: Response::HTTP_CREATED
        );

    }

    public function show(string $slug):JsonResponse{
        $business = Business::query()
            ->where('slug', $slug)
            ->firstOrFail();
        return $this->success(
            data:[
                'business' => BusinessResource::make($business),
             ]
        );
    }
}
