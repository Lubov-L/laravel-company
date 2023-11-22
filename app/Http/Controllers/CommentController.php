<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Создание комментария
     */
    public function store(CommentRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            Comment::query()->create($data);
        } catch (Exception $e) {
            Log::error('Ошибка создания комментария, log: ' . $e->getMessage());

            return response()->json(
                ['success' => false, 'error' => 'Ошибка создания комментария']
            );
        }

        return response()->json(['success' => true]);
    }

    /**
     * Получение всех комментариев
     */
    public function index(): JsonResponse
    {
        $comments = Comment::all();

        return response()->json($comments);
    }

    /**
     * Получение комментария по ID
     */
    public function show(int $id): JsonResponse
    {
        try {
            $comment = Comment::query()->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(['success' => false, 'error' => 'Комментарий не найден'], 404);
        }

        return response()->json($comment);
    }

    /**
     * Обновление комментария по ID
     */
    public function update(CommentRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $comment = Comment::query()->findOrFail($id);
        } catch (ModelNotFoundException){
            return response()->json(['success' => false, 'error' => 'Комментарий не найден'], 404);
        }

        try {
            $result = $comment->update($data);
        } catch (Exception $e) {
            Log::error('Ошибка изменения комментария, log: ' . $e->getMessage());

            return response()->json(
                ['success' => false, 'error' => 'Ошибка изменения комментария']
            );
        }

        return response()->json(['success' => $result]);
    }

    /**
     * Удаление комментария по ID
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $comment = Comment::query()->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(['success' => false, 'error' => 'Комментарий не найден'], 404);
        }

        return response()->json(['success' => $comment->delete()]);
    }
}
