<div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($articles as $article)
            <a href="{{ route('articles.show', $article->slug) }}" class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="aspect-square bg-craft-100 relative overflow-hidden">
                    @if($article->featured_image)
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-craft-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                    @endif
                    @if($article->category)
                        <span class="absolute top-2 left-2 bg-craft-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                            {{ $article->category }}
                        </span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-craft-800 group-hover:text-craft-600 transition-colors line-clamp-2">{{ $article->title }}</h3>
                    <p class="text-sm text-craft-500 mt-2 line-clamp-3">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                    <div class="flex items-center gap-2 mt-3 text-xs text-craft-400">
                        <span>{{ $article->author->name }}</span>
                        <span>•</span>
                        <span>{{ $article->published_at->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12 text-craft-500">
                <p>Belum ada artikel tersedia.</p>
            </div>
        @endforelse
    </div>

    @if($articles->hasPages())
        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    @endif
</div>
