import './bootstrap';

// Listen for Livewire toast events
document.addEventListener('livewire:init', () => {
    Livewire.on('toast', (data) => {
        window.dispatchEvent(new CustomEvent('show-toast', { 
            detail: { 
                type: data[0].type || 'success', 
                message: data[0].message,
                duration: data[0].duration || 4000
            } 
        }));
    });
});
