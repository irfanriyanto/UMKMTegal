<!-- Confirm Modal -->
<div x-data="confirmModal()" 
     x-on:show-confirm.window="show($event.detail)"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <!-- Backdrop -->
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
             @click="cancel()">
        </div>

        <!-- Modal Panel -->
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            
            <div class="sm:flex sm:items-start">
                <!-- Icon -->
                <div :class="{
                    'bg-red-100': type === 'danger',
                    'bg-yellow-100': type === 'warning',
                    'bg-craft-100': type === 'info'
                }" class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <!-- Danger Icon -->
                    <template x-if="type === 'danger'">
                        <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </template>
                    <!-- Warning Icon -->
                    <template x-if="type === 'warning'">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </template>
                    <!-- Info Icon -->
                    <template x-if="type === 'info'">
                        <svg class="w-6 h-6 text-craft-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </template>
                </div>

                <!-- Content -->
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-semibold leading-6 text-craft-900" x-text="title"></h3>
                    <div class="mt-2">
                        <p class="text-sm text-craft-500" x-text="message"></p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-3">
                <button @click="confirm()" 
                        :class="{
                            'bg-red-600 hover:bg-red-700 focus:ring-red-500': type === 'danger',
                            'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500': type === 'warning',
                            'bg-craft-600 hover:bg-craft-700 focus:ring-craft-500': type === 'info'
                        }"
                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                        x-text="confirmText">
                </button>
                <button @click="cancel()" 
                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-craft-700 bg-craft-100 border border-craft-200 rounded-lg shadow-sm hover:bg-craft-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-craft-500 sm:mt-0 sm:w-auto sm:text-sm"
                        x-text="cancelText">
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmModal() {
    return {
        open: false,
        title: '',
        message: '',
        type: 'danger',
        confirmText: 'Ya, Lanjutkan',
        cancelText: 'Batal',
        onConfirm: null,
        
        show(detail) {
            this.title = detail.title || 'Konfirmasi';
            this.message = detail.message || 'Apakah Anda yakin?';
            this.type = detail.type || 'danger';
            this.confirmText = detail.confirmText || 'Ya, Lanjutkan';
            this.cancelText = detail.cancelText || 'Batal';
            this.onConfirm = detail.onConfirm || null;
            this.open = true;
        },
        
        confirm() {
            if (this.onConfirm) {
                this.onConfirm();
            }
            this.open = false;
        },
        
        cancel() {
            this.open = false;
        }
    }
}
</script>
