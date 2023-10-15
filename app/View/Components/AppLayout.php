<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class AppLayout extends Component
{
    public Collection $categories;
    public function __construct(public ?string $metaTitle = null, public ?string $metaDescription = null)
    {
        $this->categories = Category::query()
            ->join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->select('categories.title', 'categories.slug', DB::raw('count(*) as total'))
            ->groupBy([
                'categories.title', 'categories.slug'
            ])
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {

        return view('layouts.app');
    }
}
