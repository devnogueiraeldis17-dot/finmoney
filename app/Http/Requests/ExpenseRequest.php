<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $actor = $this->user();
        $expense = $this->route('expense');
        // Ao editar, o lançamento deve pertencer ao dono da despesa; ao criar, ao usuário autenticado.
        $ownerId = $expense && $actor->isAdmin() ? $expense->user_id : $actor->id;

        return [
            'launch_id' => [
                'required', 'integer',
                Rule::exists('launches', 'id')->where('user_id', $ownerId),
            ],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:5000'],
            'value' => ['required', 'numeric', 'gt:0', 'max:9999999999.99'],
            'installments' => ['required', 'integer', 'between:1,120'],
            'due_date' => ['required', 'date'],
        ];
    }
}
