<?php

namespace Modules\Cryptocurrency\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cryptocurrency_id' => 'required|exists:cryptocurrencies,id',
            'amount' => 'required|numeric',
            'price_usd' => 'required|numeric|min:0',
            'traded_at' => 'required|date_format:Y-m-d H:i:s|before_or_equal:'.date('Y-m-d: H:i:s'),
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
