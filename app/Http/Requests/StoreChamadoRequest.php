<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PrioridadeChamado;
use Illuminate\Validation\Rule;

class StoreChamadoRequest extends FormRequest
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

            'atribuicao' => [
                'required',
                'in:manual,automatica',
            ],

            'responsavel_id' => [
                'nullable',
                'required_if:atribuicao,manual',
                'exists:responsaveis,id',
            ],
        ];
    }
}
