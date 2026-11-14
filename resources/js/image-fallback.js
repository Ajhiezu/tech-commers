const fallbackUrl = document.querySelector('meta[name="image-fallback"]')?.content;

if (fallbackUrl) {
    function useFallback(image) {
        if (!(image instanceof HTMLImageElement)) return;

        const fallback = new URL(`${image.dataset.imageType || 'product'}.svg`, fallbackUrl).href;
        // Stop if the local placeholder itself failed, while allowing a new gallery image to retry.
        if (image.src === fallback) return;

        image.removeAttribute('srcset');
        image.src = fallback;
    }

    // Capture errors from existing images, Alpine galleries, and upload previews.
    document.addEventListener('error', (event) => useFallback(event.target), true);

    function checkImages() {
        document.querySelectorAll('img').forEach((image) => {
            if (image.complete && image.naturalWidth === 0) useFallback(image);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', checkImages, { once: true });
    } else {
        checkImages();
    }
}
