import './bootstrap';
import Alpine from 'alpinejs';
import './rich-editor';

document.addEventListener('alpine:init', () => {
    Alpine.data('testimonialsCarousel', (slideCount) => ({
        active: 0,
        slideCount,

        next() {
            if (this.slideCount <= 1) {
                return;
            }
            this.active = (this.active + 1) % this.slideCount;
        },

        prev() {
            if (this.slideCount <= 1) {
                return;
            }
            this.active = (this.active - 1 + this.slideCount) % this.slideCount;
        },

        goTo(index) {
            if (index >= 0 && index < this.slideCount) {
                this.active = index;
            }
        },
    }));
});

window.Alpine = Alpine;
Alpine.start();
