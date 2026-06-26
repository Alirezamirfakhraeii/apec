<?php

namespace App\Features\Admin\Posts\Queries;

use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class GetPostsItemsDataQuery
{
    /**
     * @return array{
     *     posts: LengthAwarePaginator,
     *     categories: Collection,
     *     activeFilters: int,
     *     perPage: int
     * }
     */
    public function handle(Request $request): array
    {
        return [
            'posts'         => $this->getPosts($request),
            'categories'    => $this->getCategories(),
            'activeFilters' => $this->getActiveFilters($request),
            'perPage'       => $this->getPerPage($request),
        ];
    }

    private function getPosts(Request $request): LengthAwarePaginator
    {
        $query = Post::query()
            ->with(['blogCategory', 'mainImage']);

        $this->applySearchFilter($query, $request);
        $this->applyStatusFilter($query, $request);
        $this->applyBlogCategoryFilter($query, $request);
        $this->applyDateFilters($query, $request);
        $this->applySort($query, $request);

        return $query
            ->paginate($this->getPerPage($request))
            ->appends($request->query());
    }

    private function getCategories(): Collection
    {
        return BlogCategory::query()
            ->orderBy('name')
            ->get();
    }

    private function applySearchFilter(Builder $query, Request $request): void
    {
        if (! $request->filled('q')) {
            return;
        }

        $search = trim($request->get('q'));

        $query->where(function (Builder $query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%');
        });
    }

    private function applyStatusFilter(Builder $query, Request $request): void
    {
        if (! $request->filled('status')) {
            return;
        }

        $query->where('status', $request->get('status'));
    }

    private function applyBlogCategoryFilter(Builder $query, Request $request): void
    {
        if (! $request->filled('blog_category_id')) {
            return;
        }

        $query->where('blog_category_id', $request->get('blog_category_id'));
    }

    private function applyDateFilters(Builder $query, Request $request): void
    {
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->get('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->get('date_to'));
        }
    }

    private function applySort(Builder $query, Request $request): void
    {
        match ($request->get('sort')) {
            'oldest' => $query->oldest('created_at'),
            'views'  => $query->orderByDesc('view_count'),
            default  => $query->latest('created_at'),
        };
    }

    private function getPerPage(Request $request): int
    {
        $perPage = (int) $request->get('per_page', 20);

        return in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 20;
    }

    private function getActiveFilters(Request $request): int
    {
        return collect([
            $request->get('q'),
            $request->get('status'),
            $request->get('blog_category_id'),
            $request->get('date_from'),
            $request->get('date_to'),
            $request->get('sort'),
            $request->get('per_page'),
        ])->filter()->count();
    }
}
