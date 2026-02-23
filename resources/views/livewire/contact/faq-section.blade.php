<div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-xl font-semibold text-craft-800 mb-4">Pertanyaan Umum (FAQ)</h3>
    
    @if($faqs->count() > 0)
        <div class="space-y-4" x-data="{ open: null }">
            @foreach($faqs as $index => $faq)
                <div class="border border-craft-200 rounded-lg overflow-hidden">
                    <button @click="open = open === {{ $index }} ? null : {{ $index }}" 
                        class="w-full px-4 py-3 text-left flex justify-between items-center hover:bg-craft-50 transition">
                        <span class="font-medium text-craft-700">{{ $faq->question }}</span>
                        <svg class="w-5 h-5 text-craft-400 transition-transform" :class="{ 'rotate-180': open === {{ $index }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === {{ $index }}" x-collapse class="px-4 pb-3 text-craft-600 text-sm">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-craft-500 text-center py-4">Belum ada FAQ tersedia.</p>
    @endif
</div>
