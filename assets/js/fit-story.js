(function () {
	var section = document.querySelector('[data-fit-story]');
	if (!section) {
		return;
	}

	var images = Array.prototype.slice.call(section.querySelectorAll('[data-fit-image]'));
	var bars = section.querySelectorAll('[data-fit-bar]');
	var indexEl = section.querySelector('[data-fit-index]');

	if (images.length < 2) {
		return;
	}

	var index = 0;
	var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function pad(n) {
		return n < 10 ? '0' + n : String(n);
	}

	function show(i) {
		index = i;
		images.forEach(function (el, s) {
			el.classList.toggle('is-active', s === i);
		});
		bars.forEach(function (bar, b) {
			bar.classList.toggle('is-on', b === i);
		});
		if (indexEl) {
			indexEl.textContent = pad(i + 1);
		}
	}

	show(0);

	if (reduced) {
		return;
	}

	window.setInterval(function () {
		show((index + 1) % images.length);
	}, 2000);
})();
