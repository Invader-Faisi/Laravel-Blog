<?php
// @var $post \Illuminate\Pagination\LengthAwarePaginator
?>


<x-app-layout meta-title="Code Pedia Blogs" meta-description="Code pedia blogs about coding">
    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3">
    
        @foreach ($posts as $post)
            <x-post-item :post="$post"></x-post-item>
        @endforeach
    <!-- Pagination -->
    {{ $posts->onEachSide(1)->links() }}
    </section>
    
    <x-sidebar/>
        
</x-app-layout>


