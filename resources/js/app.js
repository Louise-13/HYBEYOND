import './bootstrap';

document.querySelectorAll('.artist-carousel__photo img').forEach((image) => {
	const placeholder = image.parentElement.querySelector('.artist-carousel__placeholder');
	const hideMissingImage = () => {
		image.hidden = true;
		placeholder?.removeAttribute('aria-hidden');
	};

	image.addEventListener('error', hideMissingImage);

	if (image.complete && image.naturalWidth === 0) hideMissingImage();
});

const artistCarousel = document.querySelector('.artist-carousel');

if (artistCarousel) {
	let resumeTimer;

	const resumeCarousel = () => {
		window.clearTimeout(resumeTimer);
		resumeTimer = window.setTimeout(() => artistCarousel.classList.remove('is-swiping'), 350);
	};

	artistCarousel.addEventListener('pointerdown', (event) => {
		if (event.pointerType === 'touch') {
			window.clearTimeout(resumeTimer);
			artistCarousel.classList.add('is-swiping');
		}
	}, { passive: true });

	artistCarousel.addEventListener('pointerup', resumeCarousel, { passive: true });
	artistCarousel.addEventListener('pointercancel', resumeCarousel, { passive: true });
	artistCarousel.addEventListener('touchend', resumeCarousel, { passive: true });
	artistCarousel.addEventListener('touchcancel', resumeCarousel, { passive: true });
	window.addEventListener('pointerup', resumeCarousel, { passive: true });
	window.addEventListener('pointercancel', resumeCarousel, { passive: true });
}
