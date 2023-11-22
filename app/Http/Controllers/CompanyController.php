<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Comment;
use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    /**
     * Создание компании
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            Company::query()->create($data);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(
                    ['success' => false, 'error' => 'Компания с таким именем уже существует']
                );
            }

            Log::error('Ошибка создания компании, log: ' . $e->getMessage());

            return response()->json(
                ['success' => false, 'error' => 'Ошибка создания компании']
            );
        }

        return response()->json(['success' => true]);
    }

    /**
     * Получение всех компаний
     */
    public function index(): JsonResponse
    {
        $companies = Company::all();

        return response()->json($companies);
    }

    /**
     * Получение компании по ID
     */
    public function show(int $id): JsonResponse
    {
        try {
            $company = Company::query()->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(['success' => false, 'error' => 'Компания не найдена'], 404);
        }

        return response()->json($company);
    }

    /**
     * Обновление компании по ID
     */
    public function update(CompanyRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $company = Company::query()->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(['success' => false, 'error' => 'Компания не найдена'], 404);
        }

        try {
            $result = $company->update($data);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(
                    ['success' => false, 'error' => 'Компания с таким названием уже существует']
                );
            }

            Log::error('Ошибка изменения компании, log: ' . $e->getMessage());

            return response()->json(
                ['success' => false, 'error' => 'Ошибка изменения компании']
            );
        }

        return response()->json(['success' => $result]);
    }

    /**
     * Удаление компании по ID
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $company = Company::query()->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(['success' => false, 'error' => 'Компания не найдена'], 404);
        }

        return response()->json(['success' => $company->delete()]);
    }

    /**
     * Получение комментариев компании по ID
     */
    public function getCommentsByCompanyId($companyId)
    {
        $comments = Comment::query()->where('company_id', $companyId)->get();

        return response()->json($comments);
    }

    /**
     * Получение общей оценки компании
     */
    public function getCompanyRating(Comment $comment, int $companyId): JsonResponse
    {
        return response()->json($comment->rating($companyId));
    }

    /**
     * Получение топ-10 компаний
     */
    public function getTop(Comment $comment)
    {
        return response()->json($comment->top());
    }
}
