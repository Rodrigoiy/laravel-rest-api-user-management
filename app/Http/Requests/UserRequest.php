<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Manipular falhas de validação e retornar uma resposta JSON com os erros de validação.
     * 
     * @param // \Illuminate\Contracts\Validation\Validation $validation O objeto de validação que contém os erros da validação.
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422)); // O código de status HTTP 422 significa "Unprocessable Enity" (Entidade não Processável). Esse código é usado quando o servidor entende a requisição do cliente, mas não pode processa-lá devido a erros de validação no lado do servidor.
    }

    /**
    * Retorna as regras de validação para os dados do usuário.
    *
    * //@return array<string, \Illuminate\Contracts\Validation\ValidationRules|array<mixed>|string>
     */
    public function rules(): array
    {
        
        // Recuperar o id do usuário enviado na URL
        $userId = $this->route('user');

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($userId ? $userId->id : null),
            'password' => 'required|min:6'
        ];
    }

    /**
     * Retorna as mensagens de erro personalizadas para as regras de validação.
     * 
     * @return array
     */
    public function messages() : array 
    {
        return[
            'name.required' => 'Campo nome é obrigatório!',
            'email.required' => 'Campo e-mail é obrigatório!',
            'email.email' => 'Necessário enviar e-mail válido!',
            'email.unique' => 'O e-mail já está cadastrado!',
            'password.required' => 'Campo senha obrigatório!',
            'password.min' => 'Senha com no mínimo :min caracteres!',
        ];
    }
}
