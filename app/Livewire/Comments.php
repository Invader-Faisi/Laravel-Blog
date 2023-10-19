<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\On;

class Comments extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }
    public function render()
    {
        $comments = $this->selectComments();
        return view('livewire.comments', compact('comments'));
    }

    private function selectComments()
    {
        return Comment::where('post_id', '=', $this->post->id)
            ->with(['post', 'user', 'comments'])
            ->whereNull('parent_id')
            ->orderByDesc('created_at')
            ->get();
    }

    #[On('commentCreated')]
    public function commentCreated()
    {
        $this->render();
    }

    #[On('commentDeleted')]
    public function commentDeleted()
    {
        $this->render();
    }
}
