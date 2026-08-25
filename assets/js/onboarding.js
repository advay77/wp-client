(function () {
	var page = document.querySelector('.ob-page');
	if (!page || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		if (page) {
			page.querySelectorAll('[data-ob-reveal]').forEach(function (el) {
				el.classList.add('is-visible');
			});
			var fill = page.querySelector('[data-ob-spine-fill]');
			if (fill) {
				fill.style.height = '100%';
			}
		}
		return;
	}

	document.documentElement.classList.add('ob-smooth-scroll');

	var steps = page.querySelectorAll('.ob-step');
	var spineFill = page.querySelector('[data-ob-spine-fill]');
	var spineBeam = page.querySelector('[data-ob-spine-beam]');
	var progressDots = page.querySelectorAll('[data-ob-progress-dot]');
	var timeline = page.querySelector('[data-ob-timeline]');

	function setActiveStep(i) {
		steps.forEach(function (step, s) {
			step.classList.toggle('is-active', s === i);
		});
		progressDots.forEach(function (dot, d) {
			dot.classList.toggle('is-on', d === i);
		});
	}

	if ('IntersectionObserver' in window) {
		var revealObs = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-visible');
						revealObs.unobserve(entry.target);
					}
				});
			},
			{ threshold: 0.12, rootMargin: '0px 0px -6% 0px' }
		);
		page.querySelectorAll('[data-ob-reveal]').forEach(function (el) {
			revealObs.observe(el);
		});
	} else {
		page.querySelectorAll('[data-ob-reveal]').forEach(function (el) {
			el.classList.add('is-visible');
		});
	}

	if (steps.length) {
		var stepObs = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						var i = parseInt(entry.target.getAttribute('data-step-index'), 10);
						if (!isNaN(i)) {
							setActiveStep(i);
						}
					}
				});
			},
			{ threshold: 0.45, rootMargin: '-20% 0px -35% 0px' }
		);
		steps.forEach(function (step) {
			stepObs.observe(step);
		});
		setActiveStep(0);
	}

	function updateSpine(pct) {
		if (spineFill) {
			spineFill.style.height = pct + '%';
		}
		if (spineBeam) {
			spineBeam.style.top = pct + '%';
			spineBeam.classList.toggle('is-live', pct > 1.5);
		}
	}

	if (timeline && spineFill && window.gsap && window.ScrollTrigger) {
		var gsap = window.gsap;
		gsap.registerPlugin(window.ScrollTrigger);

		gsap.from('.ob-hero-inner > *', {
			opacity: 0,
			y: 24,
			duration: 0.7,
			stagger: 0.1,
			ease: 'power2.out'
		});

		gsap.to(spineFill, {
			height: '100%',
			ease: 'none',
			scrollTrigger: {
				trigger: timeline,
				start: 'top 70%',
				end: 'bottom 25%',
				scrub: 0.45
			}
		});

		if (spineBeam) {
			gsap.to(spineBeam, {
				top: '100%',
				ease: 'none',
				scrollTrigger: {
					trigger: timeline,
					start: 'top 70%',
					end: 'bottom 25%',
					scrub: 0.45,
					onUpdate: function (self) {
						spineBeam.classList.toggle('is-live', self.progress > 0.02);
					}
				}
			});
		}

		steps.forEach(function (step) {
			gsap.from(step.querySelector('.ob-card'), {
				scrollTrigger: {
					trigger: step,
					start: 'top 82%',
					toggleActions: 'play none none reverse'
				},
				opacity: 0,
				y: 32,
				duration: 0.65,
				ease: 'power2.out'
			});
		});
	} else if (timeline && spineFill) {
		var ticking = false;
		var scrollUpdate = function () {
			var rect = timeline.getBoundingClientRect();
			var viewH = window.innerHeight || document.documentElement.clientHeight;
			var start = viewH * 0.2;
			var end = Math.max(rect.height - viewH * 0.35, 1);
			var scrolled = start - rect.top;
			var pct = Math.min(100, Math.max(0, (scrolled / end) * 100));
			updateSpine(pct);
			ticking = false;
		};
		window.addEventListener(
			'scroll',
			function () {
				if (!ticking) {
					window.requestAnimationFrame(scrollUpdate);
					ticking = true;
				}
			},
			{ passive: true }
		);
		scrollUpdate();
	}
})();
