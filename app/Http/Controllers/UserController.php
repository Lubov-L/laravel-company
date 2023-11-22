<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Создание пользователя
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            User::query()->create($data);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(
                    ['success' => false, 'error' => 'Пользователь с таким номером телефона уже существует']
                );
            }

            Log::error('Ошибка создания пользователя, log: ' . $e->getMessage());

            return response()->json(
                ['success' => false, 'error' => 'Ошибка создания пользователя']
            );
        }

        return response()->json(['success' => true]);
    }

    /**
     * Получение всех пользователей
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Получение пользователя по ID
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = User::query()->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(['success' => false, 'error' => 'Пользователь не найден'], 404);
        }

        return response()->json($user);
    }

    /**
     * Обновление пользователя по ID
     */
    public function update(UserRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $user = User::query()->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(['success' => false, 'error' => 'Пользователь не найден'], 404);
        }

        try {
            $result = $user->update($data);;
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(
                    ['success' => false, 'error' => 'Пользователь с таким номером телефона уже существует']
                );
            }

            Log::error('Ошибка изменения пользователя, log: ' . $e->getMessage());

            return response()->json(
                ['success' => false, 'error' => 'Ошибка изменения пользователя']
            );
        }

        return response()->json(['success' => $result]);
    }

    /**
     * Удаление пользователя по ID
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $user = User::query()->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(['success' => false, 'error' => 'Пользователь не найден'], 404);
        }

        return response()->json(['success' => $user->delete()]);
    }
}
