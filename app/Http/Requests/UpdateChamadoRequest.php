<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PrioridadeChamado;
use App\Enums\StatusChamado;
use Illuminate\Validation\Rule;

class UpdateChamadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => [
                'required',
                'string',
                'max:255',
            ],

            'descricao' => [
                'required',
                'string',
            ],

            'prioridade' => [
                'required',
                Rule::enum(PrioridadeChamado::class),
            ],

            'status' => [
                'required',
                Rule::enum(StatusChamado::class),
            ],

            'responsavel_id' => [
                'required',
                'exists:responsaveis,id',
            ],
        ];
    }
}
