import { initPreloader } from './preloader';
import { activateReveal, prepareReveal } from './reveal';

export function initMotion() {
    if (document.body.dataset.motionInit === 'true') {
        return;
    }

    document.body.dataset.motionInit = 'true';
    document.body.classList.add('preloader-active');

    prepareReveal();

    initPreloader(() => {
        activateReveal();
    });
}
