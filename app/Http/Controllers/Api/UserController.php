<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Retorna uma lista paginada de usuários.
     * 
     * Este método recupera uma lista paginada de usuários do banco de dados e a retorna como uma resposta JSON.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        // Recuperar os usuários do banco de dados, ordenando id em ordem decrescente, paginados 
        $users = User::orderBy('id', 'DESC')->paginate(2);

        // Retornar os usuários recuperados como uma resposta JSON
        return response()->json([
            'status' => true,
            'Users' => $users,
        ], 200);
    }


    /**
     * Exibe os detalhes de um usuário específico.
     * 
     * Este método retorna os detalhes de um usuário específico em formato JSON.
     * 
     * @param \App\Models\User $user o objeto do usuário a ser exibido
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        // Retorna os detalhes do usuário em formato JSON
        return response()->json([
            'status' => true,
            'User' => $user,
        ], 200);
    }


    /**
     * Cria novo usuário com os dados fornecidos na requisição.
     * 
     * @param \App\Http\Requests\UserRequest $request O objeto de requisição contendo os dados do usuário a ser criado.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        //Iniciar a transação
        DB::beginTransaction();

        try {

            // Cadastrar usuário no banco de dados
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Operação é concluída com êxito
            DB::commit();

            // Retorna os dados do usuário criado e uma mensagem de sucesso com status 201
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário cadastrado com sucesso!",
            ], 201);

        } catch (Exception $e) {

            // Operação não é concluída com êxito
            DB::Rollback();

            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não cadastrado!",
            ], 400);

        }
    }


    /**
     * Atualizar os dados de um usuário existente com base nos dados fornecidos na requisição.
     * 
     * @param \App\Http\Requests\UserRequest $require O objeto de requisição contendo os dados do usuário a ser atualizado.
     * @param \App\models\User $user O usuário a ser utilizado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {

        // Iniciar transação
        DB::beginTransaction();

        try {

            // Editar o registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,

            ]);

            // Operação é concluída com êxito
            DB::commit();

            // Retorna os dados do usuário editado e uma mensagem de sucesso com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário editado  com sucesso!",
            ], 200);

        } catch (Exception $e) {

            // Operação não é concluída com êxito
            DB::Rollback();

            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não editado!",
            ], 400);
        }
    }

    /**
     * Excluir usuário no banco de dados.
     * 
     * @param \App\Models\User $user O usuário a ser excluído.
     * @return /\Illuminate\Http|JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            // Apagar o registro no banco de dados
            $user->delete();

            // Retorna os dados do usuário apagado e uma mensagem de sucesso com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário apagado com sucesso!"
            ], 200);

        } catch (Exception $e) {
            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não apagado!",
            ], 400);
        }
    }
}
