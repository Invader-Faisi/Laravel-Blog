<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\UpvoteDownvote as ModelsUpvoteDownvote;
use Livewire\Component;

class UpvoteDownVote extends Component
{
    public Post $post;
    public function mount(Post $post)
    {
        $this->post = $post;
    }
    public function render()
    {
        $upvotes = ModelsUpvoteDownvote::where('post_id', '=', $this->post->id)
            ->where('is_upvote', '=', true)
            ->count();

        $downvotes = ModelsUpvoteDownvote::where('post_id', '=', $this->post->id)
            ->where('is_upvote', '=', false)
            ->count();

        // the status wether current user has upvoted or not
        $hasUpvote = null;
        /** @var \App\Models\User $user */
        $user = request()->user();

        if ($user) {
            $model = ModelsUpvoteDownvote::where('post_id', '=', $this->post->id)
                ->where('user_id', '=', $user->id)
                ->first();
            if ($model) {
                $hasUpvote = !!$model->is_upvote;
            }
        }
        return view('livewire.upvote-down-vote', compact('upvotes', 'downvotes', 'hasUpvote'));
    }

    public function upvoteDownvote($upvote = true)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();
        if (!$user) {
            return $this->redirect('login');
        }

        if (!$user->hasVerifiedEmail()) {
            return $this->redirect(route('verification.notice'));
        }

        $model = ModelsUpvoteDownvote::where('post_id', '=', $this->post->id)
            ->where('user_id', '=', $user->id)
            ->first();

        if (!$model) {
            ModelsUpvoteDownvote::create([
                'is_upvote' => $upvote,
                'post_id' => $this->post->id,
                'user_id' => $user->id
            ]);
            return;
        }

        if ($upvote && $model->is_upvote || !$upvote && !$model->is_upvote) {
            $model->delete();
        } else {
            $model->is_upvote = $upvote;
            $model->save();
        }
    }
}
