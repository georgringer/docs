import Modal from '@typo3/backend/modal.js';
import Severity from '@typo3/backend/severity.js';

document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-docs-toolbar-trigger]');
    if (!trigger) {
        return;
    }
    event.preventDefault();

    const iframe = document.createElement('iframe');
    iframe.src = trigger.dataset.docsUrl;
    iframe.style.cssText = 'width: 100%; height: 75vh; border: none; display: block;';

    Modal.advanced({
        title: trigger.dataset.docsTitle,
        content: iframe,
        size: Modal.sizes.full,
        severity: Severity.notice,
        buttons: [],
    });
});
