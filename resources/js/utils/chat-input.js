export function autoResizeTextarea(el) {
    const maxHeight = 110;

    el.style.height = 'auto';

    const newHeight = Math.min(el.scrollHeight, maxHeight);

    el.style.height = newHeight + 'px';

    el.style.overflowY = el.scrollHeight > maxHeight ? 'auto' : 'hidden';
}