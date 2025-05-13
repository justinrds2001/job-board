<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;

    public static array $experience = ['entry', 'intermediate', 'senior'];
    public static array $category = ['IT', 'Finance', 'Sales', 'Marketing'];

    public function scopeFilter(Builder|QueryBuilder $query, array $filters): Builder|QueryBuilder {
        $search = $filters['search'] ?? null;
        $minSalary = $filters['min-salary'] ?? null;
        $maxSalary = $filters['max-salary'] ?? null;
        $experience = $filters['experience'] ?? null;
        $category = $filters['category'] ?? null;

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($minSalary) $query->where('salary', '>=', $minSalary);
        if ($maxSalary) $query->where('salary', '<=', $maxSalary);
        if ($experience) $query->where('experience', $experience);
        if ($category) $query->where('category', $category);

        return $query;
    }
}
