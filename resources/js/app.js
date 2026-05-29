import './bootstrap';
import Alpine from 'alpinejs';
import './rich-editor';
import { initMotion } from './motion';

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function scrollToHashTarget(hash) {
    if (!hash || hash === '#') {
        return;
    }

    const target = document.querySelector(hash);

    if (!target) {
        return;
    }

    target.scrollIntoView({
        behavior: prefersReducedMotion() ? 'auto' : 'smooth',
        block: 'start',
    });
}

function initAnchorSmoothScroll() {
    if (window.location.hash) {
        requestAnimationFrame(() => scrollToHashTarget(window.location.hash));
    }

    document.addEventListener('click', (event) => {
        const anchor = event.target.closest('a[href]');

        if (!anchor) {
            return;
        }

        const href = anchor.getAttribute('href');

        if (!href || !href.includes('#')) {
            return;
        }

        let url;

        try {
            url = new URL(anchor.href, window.location.href);
        } catch {
            return;
        }

        if (!url.hash || url.hash === '#') {
            return;
        }

        const isSamePage =
            url.pathname === window.location.pathname
            && url.hostname === window.location.hostname;

        if (!isSamePage) {
            return;
        }

        const target = document.querySelector(url.hash);

        if (!target) {
            return;
        }

        event.preventDefault();

        if (window.location.hash !== url.hash) {
            history.pushState(null, '', `${url.pathname}${url.search}${url.hash}`);
        }

        scrollToHashTarget(url.hash);
    });
}

document.addEventListener('alpine:init', () => {
    Alpine.data('clientPortalLookup', (config) => ({
        tab: config.initialTab ?? 'title',
        loading: false,
        successMessage: null,
        errorMessage: null,

        clearMessages() {
            this.successMessage = null;
            this.errorMessage = null;
        },

        async submit(type, event) {
            const form = event.target;
            const url = type === 'title' ? config.titleUrl : config.paymentUrl;

            this.loading = true;
            this.clearMessages();

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                const data = await response.json().catch(() => ({}));

                if (! response.ok) {
                    if (response.status === 422) {
                        const errors = data.errors ?? {};
                        const firstField = Object.values(errors)[0];
                        this.errorMessage = Array.isArray(firstField) ? firstField[0] : config.genericError;
                    } else if (response.status === 429) {
                        this.errorMessage = 'Too many attempts. Please wait a moment and try again.';
                    } else {
                        this.errorMessage = data.message ?? config.genericError;
                    }

                    return;
                }

                if (data.success) {
                    this.successMessage = data.message;
                    if (data.download_url) {
                        window.location.assign(data.download_url);
                    }
                } else {
                    this.errorMessage = data.message ?? config.genericError;
                }
            } catch {
                this.errorMessage = config.genericError;
            } finally {
                this.loading = false;
            }
        },
    }));

    Alpine.data('bookVisitForm', (config) => ({
        loading: false,
        submitted: false,
        successMessage: null,
        errorMessage: null,
        fieldErrors: {},

        clearMessages() {
            this.successMessage = null;
            this.errorMessage = null;
            this.fieldErrors = {};
        },

        applyFieldErrors(errors) {
            this.fieldErrors = {};
            for (const [field, messages] of Object.entries(errors)) {
                this.fieldErrors[field] = Array.isArray(messages) ? messages[0] : messages;
            }
        },

        resetForm() {
            this.submitted = false;
            this.clearMessages();
            const form = this.$el.querySelector('form');
            if (form) {
                form.reset();
            }
        },

        async submit(event) {
            const form = event.target;

            this.loading = true;
            this.clearMessages();

            try {
                const response = await fetch(config.url, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                const data = await response.json().catch(() => ({}));

                if (! response.ok) {
                    if (response.status === 422) {
                        this.applyFieldErrors(data.errors ?? {});
                        this.errorMessage = 'Please fix the highlighted fields below.';
                    } else if (response.status === 429) {
                        this.errorMessage = 'Too many requests. Please wait a moment and try again.';
                    } else {
                        this.errorMessage = data.message ?? config.genericError;
                    }

                    this.$el.querySelector('.book-visit-alert-error')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                    return;
                }

                if (data.success) {
                    this.successMessage = data.message;
                    this.submitted = true;
                    this.$el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    this.errorMessage = data.message ?? config.genericError;
                }
            } catch {
                this.errorMessage = config.genericError;
            } finally {
                this.loading = false;
            }
        },
    }));

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
initMotion();

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAnchorSmoothScroll);
} else {
    initAnchorSmoothScroll();
}
