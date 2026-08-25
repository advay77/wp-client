(function () {
	'use strict';

	var section = document.querySelector('[data-inventory-journey]');
	if (!section) {
		return;
	}

	var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if (reducedMotion) {
		section.classList.add('is-static');
		return;
	}

	if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
		section.classList.add('is-static');
		return;
	}

	gsap.registerPlugin(ScrollTrigger);

	var pin = section.querySelector('[data-ij-pin]');
	var layers = section.querySelectorAll('[data-ij-layer]');
	var copies = section.querySelectorAll('[data-ij-copy]');
	var steps = section.querySelectorAll('[data-ij-step]');
	var rails = section.querySelectorAll('[data-ij-rail]');
	var protagonist = section.querySelector('[data-ij-protagonist]');
	var videos = section.querySelectorAll('[data-ij-video]');

	if (!pin || !layers.length) {
		return;
	}

	var STAGES = [
		{ start: 0, end: 0.15, mid: 0.075 },
		{ start: 0.15, end: 0.3, mid: 0.225 },
		{ start: 0.3, end: 0.45, mid: 0.375 },
		{ start: 0.45, end: 0.65, mid: 0.55 },
		{ start: 0.65, end: 0.85, mid: 0.75 },
		{ start: 0.85, end: 1, mid: 0.925 }
	];

	var TRANSITIONS = [
		{ outAt: 0.12, inAt: 0.15 },
		{ outAt: 0.27, inAt: 0.3 },
		{ outAt: 0.42, inAt: 0.45 },
		{ outAt: 0.62, inAt: 0.65 },
		{ outAt: 0.82, inAt: 0.85 }
	];

	var currentStage = -1;
	var masterTimeline = null;
	var scrollTriggerRef = null;

	function setStage(index) {
		if (index === currentStage) {
			return;
		}
		currentStage = index;

		steps.forEach(function (step, i) {
			var active = i === index;
			step.classList.toggle('is-active', active);
			step.setAttribute('aria-current', active ? 'step' : 'false');
		});

		rails.forEach(function (rail, i) {
			rail.classList.toggle('is-active', i === index);
		});

		copies.forEach(function (copy, i) {
			copy.setAttribute('aria-hidden', i === index ? 'false' : 'true');
		});
	}

	function stageFromProgress(progress) {
		for (var i = STAGES.length - 1; i >= 0; i--) {
			if (progress >= STAGES[i].start) {
				return i;
			}
		}
		return 0;
	}

	function scrubVideos(progress) {
		videos.forEach(function (video, i) {
			var seg = STAGES[i];
			if (!seg || !video.duration || isNaN(video.duration)) {
				return;
			}
			if (progress >= seg.start && progress < seg.end) {
				var local = (progress - seg.start) / (seg.end - seg.start);
				video.currentTime = Math.min(video.duration - 0.05, Math.max(0, local * video.duration));
			}
		});
	}

	function scrollToProgress(targetProgress) {
		if (!scrollTriggerRef) {
			return;
		}
		var y = scrollTriggerRef.start + (scrollTriggerRef.end - scrollTriggerRef.start) * targetProgress;
		window.scrollTo({ top: y, behavior: 'smooth' });
	}

	function bindHashNavigation() {
		var hash = window.location.hash.replace('#', '');
		if (!hash) {
			return;
		}

		for (var i = 0; i < STAGES.length; i++) {
			var copy = copies[i];
			if (copy && copy.id === hash) {
				scrollToProgress(STAGES[i].mid);
				return;
			}
		}
	}

	videos.forEach(function (video) {
		video.addEventListener('loadedmetadata', function () {
			ScrollTrigger.refresh();
		});
	});

	var ctx = gsap.context(function () {
		gsap.set(layers, { autoAlpha: 0, scale: 1.04, x: 24 });
		gsap.set(layers[0], { autoAlpha: 1, scale: 1, x: 0 });
		gsap.set(copies, { autoAlpha: 0, y: 18 });
		gsap.set(copies[0], { autoAlpha: 1, y: 0 });
		gsap.set(protagonist, { xPercent: -42, yPercent: 28, scale: 0.82, autoAlpha: 1 });

		masterTimeline = gsap.timeline({
			defaults: { ease: 'none' },
			scrollTrigger: {
				trigger: pin,
				start: 'top top',
				end: '+=600%',
				pin: true,
				scrub: 1,
				anticipatePin: 1,
				invalidateOnRefresh: true,
				onUpdate: function (self) {
					setStage(stageFromProgress(self.progress));
					scrubVideos(self.progress);
				}
			}
		});

		scrollTriggerRef = masterTimeline.scrollTrigger;

		TRANSITIONS.forEach(function (t, i) {
			var next = i + 1;
			var dur = 0.08;

			masterTimeline.to(
				layers[i],
				{ autoAlpha: 0, scale: 1.03, x: -28, duration: dur },
				t.outAt
			);
			masterTimeline.fromTo(
				layers[next],
				{ autoAlpha: 0, scale: 1.06, x: 36 },
				{ autoAlpha: 1, scale: 1, x: 0, duration: dur },
				t.inAt
			);

			masterTimeline.to(copies[i], { autoAlpha: 0, y: -10, duration: dur * 0.75 }, t.outAt);
			masterTimeline.fromTo(
				copies[next],
				{ autoAlpha: 0, y: 14 },
				{ autoAlpha: 1, y: 0, duration: dur * 0.75 },
				t.inAt
			);
		});

		masterTimeline
			.to(protagonist, { xPercent: -42, yPercent: 28, scale: 0.82, duration: 0.15 }, 0)
			.to(protagonist, { xPercent: -22, yPercent: 14, scale: 0.88, duration: 0.15 }, 0.15)
			.to(protagonist, { xPercent: -2, yPercent: 4, scale: 0.94, duration: 0.15 }, 0.3)
			.to(protagonist, { xPercent: 18, yPercent: -2, scale: 1, duration: 0.2 }, 0.45)
			.to(protagonist, { xPercent: 38, yPercent: -8, scale: 1, duration: 0.2 }, 0.65)
			.to(protagonist, { xPercent: 58, yPercent: -14, scale: 0.96, duration: 0.075 }, 0.85)
			.to(protagonist, { xPercent: 10, yPercent: 18, scale: 0.9, duration: 0.075 }, 0.925);

		masterTimeline.to(section.querySelector('.ij-visual'), { scale: 1.02, duration: 0.35 }, 0.65);
		masterTimeline.to(section.querySelector('.ij-vignette'), { opacity: 0.55, duration: 0.2 }, 0.85);

		setStage(0);
	}, section);

	steps.forEach(function (step) {
		step.addEventListener('click', function () {
			var index = parseInt(step.getAttribute('data-ij-step'), 10);
			if (!isNaN(index) && STAGES[index]) {
				scrollToProgress(STAGES[index].mid);
			}
		});
	});

	window.addEventListener('load', function () {
		ScrollTrigger.refresh();
		bindHashNavigation();
	});

	window.addEventListener('hashchange', bindHashNavigation);

	window.addEventListener('pagehide', function () {
		ctx.revert();
	});
})();
