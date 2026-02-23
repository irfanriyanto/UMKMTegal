<div>
    @if($article)
        <article class="bg-white rounded-xl shadow-md overflow-hidden">
            {{-- Article Featured Image - Fixed 1:1 ratio --}}
            <div class="flex justify-center py-6 bg-craft-50" style="box-shadow: inset 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                @if($article->featured_image)
                    <div class="overflow-hidden rounded-lg shadow-md flex-shrink-0" style="width: 320px; height: 320px;">
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="bg-gradient-to-br from-craft-400 to-kayu-500 flex items-center justify-center text-white rounded-lg flex-shrink-0" style="width: 320px; height: 320px;">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="p-8">
                @if($article->category)
                    <span class="text-sm text-batik-600 font-medium">{{ $article->category }}</span>
                @endif
                <h1 class="text-3xl font-bold text-craft-800 mt-2">{{ $article->title }}</h1>
                <div class="flex items-center gap-4 mt-4 text-sm text-craft-500">
                    <span>{{ $article->author->name }}</span>
                    <span>•</span>
                    <span>{{ $article->published_at->format('d M Y') }}</span>
                </div>
                <div class="mt-8 prose prose-craft max-w-none whitespace-pre-line" style="text-align: justify;">
                    {{ $article->content }}
                </div>
            </div>
        </article>
    @else
        <div class="text-center py-12">
            <p class="text-craft-500">Artikel tidak ditemukan.</p>
            <a href="{{ route('articles.index') }}" class="text-craft-600 hover:underline mt-4 inline-block">Kembali ke daftar artikel</a>
        </div>
    @endif
</div>
