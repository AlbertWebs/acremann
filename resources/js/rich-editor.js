import Quill from 'quill';
import 'quill/dist/quill.snow.css';

document.querySelectorAll('[data-rich-editor]').forEach((textarea) => {
    const wrapper = document.createElement('div');
    wrapper.className = 'rich-editor-wrap';
    textarea.parentNode.insertBefore(wrapper, textarea);
    textarea.classList.add('hidden');

    const editorEl = document.createElement('div');
    editorEl.className = 'rich-editor-body';
    wrapper.appendChild(editorEl);

    const quill = new Quill(editorEl, {
        theme: 'snow',
        placeholder: textarea.getAttribute('placeholder') || 'Write your message…',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link'],
                ['clean'],
            ],
        },
    });

    if (textarea.value) {
        quill.root.innerHTML = textarea.value;
    }

    const form = textarea.closest('form');
    if (form) {
        form.addEventListener('submit', () => {
            textarea.value = quill.root.innerHTML;
        });
    }
});
