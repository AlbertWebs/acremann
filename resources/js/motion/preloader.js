const MAX_WAIT_MS = 2500;
const FADE_DURATION_MS = 400;

export function initPreloader(onComplete) {
    const preloader = document.getElementById('site-preloader');

    if (! preloader) {
        document.body.classList.remove('preloader-active');
        onComplete?.();
        return;
    }

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const finish = () => {
        document.body.classList.remove('preloader-active');

        if (reducedMotion) {
            preloader.remove();
            onComplete?.();
            return;
        }

        preloader.classList.add('site-preloader--exit');

        window.setTimeout(() => {
            preloader.remove();
            onComplete?.();
        }, FADE_DURATION_MS);
    };

    if (reducedMotion) {
        finish();
        return;
    }

    let completed = false;

    const complete = () => {
        if (completed) {
            return;
        }

        completed = true;
        finish();
    };

    window.addEventListener('load', complete, { once: true });
    window.setTimeout(complete, MAX_WAIT_MS);
}
