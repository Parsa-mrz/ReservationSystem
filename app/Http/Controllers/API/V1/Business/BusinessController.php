<?php

namespace App\Http\Controllers\API\V1\Business;

use App\Domain\Businesses\Actions\CreateBusinessAction;
use App\Domain\Businesses\Models\Business;
use App\Domain\Businesses\Resources\BusinessResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Businesses\StoreBusinessRequest;
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
            $request->toDTO(),
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
