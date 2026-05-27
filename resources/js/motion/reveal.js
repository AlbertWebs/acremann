/**
 * Scroll reveal via Intersection Observer.
 * Add data-reveal-ignore on any element to skip animation.
 */

const EXCLUDE_SELECTOR = [
    'header',
    'footer',
    '.site-preloader',
    '[data-reveal-ignore]',
    '[x-cloak]',
    '.property-lightbox',
    '.events-lightbox',
    '.assistant-fab-wrap',
    '.scroll-to-top',
    '.property-show-sidebar',
    '.insight-show-sidebar',
    '.events-show-sidebar',
].join(', ');

const HERO_SELECTOR = [
    '.insight-show-hero',
    '.insights-index-hero',
    '.events-index-hero',
    '.events-show-hero',
    '.service-show-hero',
    '.property-show-hero',
    '.insights-index-featured',
].join(', ');

const STAGGER_GRID_SELECTOR = [
    '.home-insights-grid',
    '.events-grid',
    '.insights-index-grid',
].join(', ');

const CARD_SELECTOR = '.home-insight-card, .events-card';

const SIDEBAR_CARD_SELECTOR = [
    '.property-show-sidebar-card',
    '.insight-show-sidebar-card',
    '.events-show-sidebar-card',
].join(', ');

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function isExcluded(element) {
    return element.matches(EXCLUDE_SELECTOR) || element.closest(EXCLUDE_SELECTOR) !== null;
}

function markReveal(element, type, { immediate = false, delay = null } = {}) {
    if (element.hasAttribute('data-reveal') || element.hasAttribute('data-reveal-ignore')) {
        return;
    }

    if (isExcluded(element)) {
        return;
    }

    element.setAttribute('data-reveal', type);

    if (immediate) {
        element.setAttribute('data-reveal-immediate', '');
    }

    if (delay !== null) {
        element.style.setProperty('--reveal-delay', `${delay}ms`);
    }
}

function applyStaggerGrids() {
    document.querySelectorAll(STAGGER_GRID_SELECTOR).forEach((grid) => {
        grid.querySelectorAll(CARD_SELECTOR).forEach((card, index) => {
            markReveal(card, 'fade-up', { delay: index * 80 });
        });
    });
}

function applySectionReveals() {
    document.querySelectorAll('main section').forEach((section) => {
        if (isExcluded(section)) {
            return;
        }

        if (section.querySelector(STAGGER_GRID_SELECTOR)) {
            return;
        }

        if (section.matches(HERO_SELECTOR)) {
            return;
        }

        markReveal(section, 'fade-up');
    });
}

function applyHeroReveals() {
    document.querySelectorAll(HERO_SELECTOR).forEach((hero) => {
        markReveal(hero, 'fade-up', { immediate: true });
    });
}

function applySidebarCardReveals() {
    document.querySelectorAll(SIDEBAR_CARD_SELECTOR).forEach((card, index) => {
        markReveal(card, 'fade', { delay: index * 60 });
    });
}

function revealImmediateElements() {
    document.querySelectorAll('[data-reveal-immediate]').forEach((element) => {
        element.classList.add('is-revealed');
    });
}

function initObserver() {
    const elements = document.querySelectorAll('[data-reveal]:not([data-reveal-immediate])');

    if (elements.length === 0) {
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (! entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-revealed');
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.12,
            rootMargin: '0px 0px -8% 0px',
        },
    );

    elements.forEach((element) => observer.observe(element));
}

export function prepareReveal() {
    if (prefersReducedMotion()) {
        return;
    }

    applySectionReveals();
    applyStaggerGrids();
    applyHeroReveals();
    applySidebarCardReveals();
}

export function activateReveal() {
    if (prefersReducedMotion()) {
        return;
    }

    revealImmediateElements();
    initObserver();
}

export function initReveal() {
    prepareReveal();
    activateReveal();
}
