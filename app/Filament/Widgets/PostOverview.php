<?php

namespace App\Filament\Widgets;

use App\Models\UpvoteDownvote;
use App\Models\PostView;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PostOverview extends Widget
{
    protected int | string | array $columnSpan = 3;

    public ?Model $record = null;
    protected function getViewData(): array
    {
        return [
            'viewCount' => PostView::where('post_id', '=', $this->record->id)->count(),
            'upvotes' => UpvoteDownVote::where('post_id', '=', $this->record->id)
                ->where('is_upvote', '=', true)->count(),
            'downvotes' => UpvoteDownVote::where('post_id', '=', $this->record->id)
                ->where('is_upvote', '=', false)->count(),
        ];
    }
    protected static string $view = 'filament.widgets.post-overview';
}
