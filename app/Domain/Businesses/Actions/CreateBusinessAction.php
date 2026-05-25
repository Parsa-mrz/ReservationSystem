<?php

namespace  App\Domain\Businesses\Actions;

use App\Domain\Businesses\Actions\Interfaces\CreatesBusiness;
use App\Domain\Businesses\DTOs\BusinessData;
use App\Domain\Businesses\Models\Business;
use App\Domain\Users\Models\User;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CreateBusinessAction implements CreatesBusiness{
    public function handle(
        BusinessData $data,
        User $owner
    ): Business {

        if($owner->businesses()->exists()){
            abort(code:Response::HTTP_UNPROCESSABLE_ENTITY,message: 'Owner already has a business.');
        }

        return Business::create([
            'owner_id' => $owner->id,

            'name' => $data->name,

            'slug' => Str::slug($data->name)
                . '-'
                . Str::random(5),
            'description' => $data->description,
            'phone' => $data->phone,
            'email' => $data->email,
            'city' => $data->city,
            'address' => $data->address,
        ]);
    }
}
