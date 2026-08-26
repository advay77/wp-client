(function () {
	'use strict';

	var space = document.getElementById('wjSpace');
	var root = document.getElementById('wjHScroll');
	var panelsEl = document.getElementById('wjPanels');
	if (!space || !root || !panelsEl) {
		return;
	}

	document.documentElement.classList.add('wj-journey-html');

	var panels = Array.prototype.slice.call(root.querySelectorAll('.wj-panel'));
	var dots = Array.prototype.slice.call(root.querySelectorAll('[data-wj-goto]'));
	var railFill = document.getElementById('wjRailFill');
	var counterNum = document.getElementById('wjCounterNum');
	var current = -1;
	var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var svgNS = 'http://www.w3.org/2000/svg';

	/* ---- isometric arts ---- */
	function addPath(parent, d, cls) {
		var p = document.createElementNS(svgNS, 'path');
		p.setAttribute('d', d);
		p.setAttribute('class', cls);
		parent.appendChild(p);
	}
	function addLine(parent, x1, y1, x2, y2, cls) {
		var l = document.createElementNS(svgNS, 'line');
		l.setAttribute('x1', x1);
		l.setAttribute('y1', y1);
		l.setAttribute('x2', x2);
		l.setAttribute('y2', y2);
		l.setAttribute('class', cls);
		parent.appendChild(l);
	}
	function addCircle(parent, cx, cy, r, cls) {
		var c = document.createElementNS(svgNS, 'circle');
		c.setAttribute('cx', cx);
		c.setAttribute('cy', cy);
		c.setAttribute('r', r);
		c.setAttribute('class', cls);
		parent.appendChild(c);
	}
	function addRect(parent, x, y, w, h, rx, cls) {
		var r = document.createElementNS(svgNS, 'rect');
		r.setAttribute('x', x);
		r.setAttribute('y', y);
		r.setAttribute('width', w);
		r.setAttribute('height', h);
		if (rx) {
			r.setAttribute('rx', rx);
		}
		r.setAttribute('class', cls);
		parent.appendChild(r);
	}
	function isoCube(parent, x, y, s, h) {
		var N = [x, y - s / 2], E = [x + s, y], S = [x, y + s / 2], W = [x - s, y];
		addPath(parent, 'M' + S[0] + ',' + S[1] + ' L' + E[0] + ',' + E[1] + ' L' + E[0] + ',' + (E[1] + h) + ' L' + S[0] + ',' + (S[1] + h) + ' Z', 'wj-iso-right');
		addPath(parent, 'M' + W[0] + ',' + W[1] + ' L' + S[0] + ',' + S[1] + ' L' + S[0] + ',' + (S[1] + h) + ' L' + W[0] + ',' + (W[1] + h) + ' Z', 'wj-iso-left');
		addPath(parent, 'M' + N[0] + ',' + N[1] + ' L' + E[0] + ',' + E[1] + ' L' + S[0] + ',' + S[1] + ' L' + W[0] + ',' + W[1] + ' Z', 'wj-iso-top');
	}
	function floor(svg) {
		addPath(svg, 'M-20,252 L440,252 L406,282 L-46,282 Z', 'wj-floor-plane');
	}
	function build0(svg) {
		floor(svg); isoCube(svg, 140, 236, 52, 12); isoCube(svg, 140, 200, 30, 32); isoCube(svg, 140, 168, 30, 32);
		addCircle(svg, 210, 150, 13, 'wj-accent-line'); addLine(svg, 219, 159, 232, 172, 'wj-accent-line');
		addRect(svg, 260, 190, 40, 52, 4, 'wj-accent-line');
		addLine(svg, 268, 204, 292, 204, 'wj-accent-line'); addLine(svg, 268, 216, 292, 216, 'wj-accent-line');
		addLine(svg, 268, 228, 284, 228, 'wj-accent-line'); addCircle(svg, 272, 240, 3, 'wj-accent-fill');
	}
	function build1(svg) {
		floor(svg); isoCube(svg, 130, 226, 46, 16); isoCube(svg, 130, 196, 28, 28);
		var g = document.createElementNS(svgNS, 'g');
		g.setAttribute('transform', 'translate(228,150) rotate(18)');
		addRect(g, 0, 0, 34, 22, 3, 'wj-accent-line'); addCircle(g, 8, 11, 2.4, 'wj-accent-line');
		addLine(g, 16, 7, 28, 7, 'wj-accent-line'); addLine(g, 16, 14, 26, 14, 'wj-accent-line');
		svg.appendChild(g);
		addLine(svg, 175, 178, 226, 158, 'wj-accent-dash');
		addPath(svg, 'M300,170 Q292,150 310,146 Q330,150 322,170 Q322,206 311,206 Q300,206 300,170 Z', 'wj-accent-line');
		addLine(svg, 305, 150, 317, 150, 'wj-accent-line');
	}
	function build2(svg) {
		floor(svg); isoCube(svg, 250, 210, 58, 46);
		addLine(svg, 250, 164, 226, 128, 'wj-accent-dash'); addLine(svg, 250, 164, 274, 128, 'wj-accent-dash');
		addLine(svg, 192, 210, 250, 164, 'wj-accent-dash'); addLine(svg, 308, 210, 250, 164, 'wj-accent-dash');
		isoCube(svg, 95, 220, 18, 18); isoCube(svg, 90, 178, 16, 16); isoCube(svg, 120, 150, 15, 15);
		addLine(svg, 118, 216, 176, 214, 'wj-accent-line'); addPath(svg, 'M176,214 L168,209 L168,219 Z', 'wj-accent-fill');
		addLine(svg, 112, 176, 172, 194, 'wj-accent-line'); addPath(svg, 'M172,194 L162,192 L167,201 Z', 'wj-accent-fill');
	}
	function build3(svg) {
		floor(svg); isoCube(svg, 170, 226, 140, 12);
		for (var i = 0; i < 5; i++) { addCircle(svg, 70 + i * 54, 238, 5, 'wj-accent-line'); }
		isoCube(svg, 120, 190, 24, 26);
		addLine(svg, 40, 176, 66, 176, 'wj-accent-dash'); addLine(svg, 36, 190, 62, 190, 'wj-accent-dash');
		addLine(svg, 42, 204, 68, 204, 'wj-accent-dash');
		addPath(svg, 'M330,240 L392,240 L392,168 L352,168 Z', 'wj-accent-line');
		addLine(svg, 330, 240, 352, 196, 'wj-accent-line'); addLine(svg, 352, 196, 352, 168, 'wj-accent-line');
	}
	function build4(svg) {
		floor(svg); isoCube(svg, 190, 210, 30, 30);
		addPath(svg, 'M150,206 C120,160 220,120 262,160 C280,178 268,206 240,206', 'wj-accent-dash');
		addPath(svg, 'M240,206 L252,200 L247,213 Z', 'wj-accent-fill');
		addCircle(svg, 300, 150, 15, 'wj-accent-line'); addLine(svg, 300, 142, 300, 152, 'wj-accent-line');
		addCircle(svg, 300, 158, 1.6, 'wj-accent-fill');
	}
	[build0, build1, build2, build3, build4].forEach(function (fn, i) {
		var svg = document.getElementById('wjArt' + i);
		if (svg) { fn(svg); }
	});

	function setActive(i) {
		if (i === current) { return; }
		current = i;
		panels.forEach(function (p, idx) {
			p.classList.toggle('is-active', idx === i);
			p.style.opacity = idx === i ? '1' : '0.45';
		});
		dots.forEach(function (d, idx) { d.classList.toggle('is-active', idx === i); });
		if (counterNum) { counterNum.textContent = String(i + 1).padStart(2, '0'); }
	}

	function headerH() {
		var h = document.querySelector('.site-header');
		return h ? h.offsetHeight : 72;
	}

	function travelX() {
		return Math.max(0, panelsEl.scrollWidth - root.clientWidth);
	}

	function fallback() {
		space.classList.add('is-fallback');
		space.style.height = '';
		panelsEl.style.transform = '';
		panels.forEach(function (p) { p.style.opacity = ''; });
		setActive(0);
	}

	function progress() {
		var rect = space.getBoundingClientRect();
		var viewH = window.innerHeight;
		var total = Math.max(1, space.offsetHeight - viewH);
		var scrolled = Math.min(total, Math.max(0, -rect.top));
		return scrolled / total;
	}

	function apply(p) {
		var x = -travelX() * p;
		panelsEl.style.transform = 'translate3d(' + x + 'px,0,0)';
		if (railFill) {
			railFill.style.width = (p * 100) + '%';
		}
		var idx = Math.round(p * (panels.length - 1));
		setActive(Math.max(0, Math.min(panels.length - 1, idx)));
	}

	function layout() {
		document.documentElement.style.setProperty('--header-h', headerH() + 'px');
		var dist = travelX();
		/* ~0.9 viewport of scroll per panel — enough to scrub LTR while sticky */
		var tall = Math.round(window.innerHeight + dist * 0.95);
		space.style.height = Math.max(tall, window.innerHeight * panels.length * 0.85) + 'px';
		apply(progress());
	}

	function goTo(i) {
		i = Math.max(0, Math.min(panels.length - 1, i));
		if (space.classList.contains('is-fallback')) {
			panels[i].scrollIntoView({ behavior: 'smooth', block: 'center' });
			return;
		}
		var total = Math.max(1, space.offsetHeight - window.innerHeight);
		var p = panels.length <= 1 ? 0 : i / (panels.length - 1);
		var top = space.offsetTop + total * p;
		window.scrollTo({ top: top, behavior: reduced ? 'auto' : 'smooth' });
	}

	dots.forEach(function (btn) {
		btn.addEventListener('click', function () {
			goTo(parseInt(btn.getAttribute('data-wj-goto'), 10) || 0);
		});
	});

	if (reduced) {
		fallback();
		return;
	}

	/*
	 * Primary path: CSS sticky + scroll-linked transform.
	 * No ScrollTrigger pin — avoids body overflow-x / smooth-scroll breakage.
	 * GSAP (if present) only adds light polish on the active art.
	 */
	var ticking = false;
	function onScroll() {
		if (ticking) { return; }
		ticking = true;
		requestAnimationFrame(function () {
			ticking = false;
			var p = progress();
			apply(p);

			if (typeof gsap !== 'undefined') {
				panels.forEach(function (panel, i) {
					var center = panels.length <= 1 ? 0 : i / (panels.length - 1);
					var near = Math.max(0, 1 - Math.abs(p - center) * panels.length);
					var art = panel.querySelector('.wj-scene-art');
					if (art) {
						gsap.set(art, { scale: 0.92 + near * 0.08, y: (1 - near) * 16 });
					}
				});
			}
		});
	}

	layout();
	setActive(0);
	onScroll();

	window.addEventListener('scroll', onScroll, { passive: true });
	window.addEventListener('resize', function () {
		layout();
	});
	window.addEventListener('load', function () {
		layout();
		hashJump();
	});

	function hashJump() {
		var hash = (window.location.hash || '').replace('#', '');
		if (!hash) { return; }
		var el = document.getElementById(hash);
		if (!el || !el.classList.contains('wj-panel')) { return; }
		var i = parseInt(el.getAttribute('data-wj-panel'), 10);
		if (!isNaN(i)) {
			setTimeout(function () { goTo(i); }, 120);
		}
	}

	window.addEventListener('hashchange', hashJump);
})();
