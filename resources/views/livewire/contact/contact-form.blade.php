<div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-xl font-semibold text-craft-800 mb-4">Kirim Pesan</h3>
    
    @if($submitted)
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
            <p class="font-medium">Pesan berhasil dikirim!</p>
            <p class="text-sm">Terima kasih telah menghubungi kami. Kami akan segera merespons pesan Anda.</p>
        </div>
    @endif

    <form wire:submit="submit" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-craft-700 mb-1">Nama</label>
            <input type="text" id="name" wire:model="name" 
                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 @error('name') border-red-500 @enderror">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-craft-700 mb-1">Email</label>
            <input type="email" id="email" wire:model="email" 
                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 @error('email') border-red-500 @enderror">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="subject" class="block text-sm font-medium text-craft-700 mb-1">Subjek</label>
            <input type="text" id="subject" wire:model="subject" 
                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 @error('subject') border-red-500 @enderror">
            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-craft-700 mb-1">Pesan</label>
            <textarea id="message" wire:model="message" rows="5" 
                class="w-full rounded-lg border-craft-300 focus:border-craft-500 focus:ring-craft-500 @error('message') border-red-500 @enderror"></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-craft-500 hover:bg-craft-600 text-white font-semibold py-2 px-4 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2" wire:loading.attr="disabled">
            <svg wire:loading wire:target="submit" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span wire:loading.remove wire:target="submit">Kirim Pesan</span>
            <span wire:loading wire:target="submit">Mengirim...</span>
        </button>
    </form>
</div>
