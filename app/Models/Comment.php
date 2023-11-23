<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    public $timestamps = false;

    protected $guarded = false;

    /**
     * Выборка данных по рейтингу компаний
     */
    public function top(): Collection
    {
        return $this->join('companies', 'comments.company_id', '=', 'companies.id')
            ->select('companies.name', DB::raw('AVG(comments.rating) as average_rating'))
            ->groupBy('companies.id', 'companies.name')
            ->orderByDesc('average_rating')
            ->limit(10)
            ->get();
    }

    /**
     * Выборка рейтинга компании
     */
    public function rating(int $companyId): array
    {
        $rating = $this->join('companies', 'comments.company_id', '=', 'companies.id')
            ->where('comments.company_id', $companyId)
            ->avg('rating');

        $companyName = Company::find($companyId)->name;

        return ['name' => $companyName, 'rating' => $rating];
    }
}
