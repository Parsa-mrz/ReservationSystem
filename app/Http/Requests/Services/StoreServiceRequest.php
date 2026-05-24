<?php

namespace App\Http\Requests\Services;

use App\Domain\Services\DTOs\ServiceData;
use App\Domain\Services\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', [Service::class,$this->route('business')]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'duration' => [
                'required',
                'integer',
                'min:5',
                'max:480',
            ],

            'buffer_time' => [
                'nullable',
                'integer',
                'min:0',
                'max:120',
            ],

            'price' => [
                'required',
                'decimal:0,2',
                'min:0',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => $this->normalizePrice(
                $this->input('price')
            ),
        ]);
    }

    private function normalizePrice(
        mixed $price
    ): ?string {

        if ($price === null) {
            return null;
        }

        return number_format(
            (float) $price,
            decimals: 2,
            decimal_separator: '.',
            thousands_separator: ''
        );
    }

    public function toDTO(): ServiceData
    {
        return  ServiceData::fromRequest($this);
    }
}
