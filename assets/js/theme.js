(function () {
	var toggle = document.querySelector('.menu-toggle');
	var nav = document.querySelector('.primary-nav') || document.getElementById('site-navigation');
	var header = document.querySelector('.site-header');
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (toggle && nav) {
		function setOpen(open) {
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			document.body.classList.toggle('nav-open', open);
		}

		toggle.addEventListener('click', function () {
			setOpen(toggle.getAttribute('aria-expanded') !== 'true');
		});

		nav.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function (event) {
				if (link.classList.contains('nav-trigger') && window.matchMedia('(max-width: 899px)').matches) {
					event.preventDefault();
					var item = link.closest('.has-mega');
					if (item) {
						item.classList.toggle('is-open');
					}
					return;
				}
				if (window.matchMedia('(max-width: 899px)').matches) {
					setOpen(false);
				}
			});
		});
	}

	document.querySelectorAll('.has-mega > .nav-trigger').forEach(function (link) {
		link.addEventListener('click', function (event) {
			if (!window.matchMedia('(min-width: 900px)').matches) {
				return;
			}
			var item = link.closest('.has-mega');
			// Blogs: hover shows mega; click opens the blog page.
			if (item && item.classList.contains('is-blogs')) {
				return;
			}
			event.preventDefault();
			event.stopPropagation();
			var wasOpen = item.classList.contains('is-open');
			document.querySelectorAll('.has-mega.is-open').forEach(function (el) {
				if (el !== item) {
					el.classList.remove('is-open');
				}
			});
			item.classList.toggle('is-open', !wasOpen);
		});
	});

	if (header) {
		var onScroll = function () {
			header.classList.toggle('is-scrolled', window.scrollY > 8);
		};
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	var video = document.getElementById('hero-video');
	var media = document.querySelector('.hero-media');
	var tabs = document.querySelectorAll('.hero-tab');

	function playClip(src) {
		if (!video || !src) {
			return;
		}
		if (media) {
			media.classList.remove('is-fallback');
		}
		var source = video.querySelector('source');
		if (source) {
			source.setAttribute('src', src);
		}
		video.setAttribute('src', src);
		video.load();
		if (reduce) {
			video.pause();
			return;
		}
		var play = video.play();
		if (play && play.catch) {
			play.catch(function () {
				if (media) {
					media.classList.add('is-fallback');
				}
			});
		}
	}

	if (video) {
		video.addEventListener('error', function () {
			if (media) {
				media.classList.add('is-fallback');
			}
		});
		if (reduce) {
			video.pause();
			video.removeAttribute('autoplay');
		}
	}

	tabs.forEach(function (tab) {
		tab.addEventListener('click', function () {
			tabs.forEach(function (item) {
				item.setAttribute('aria-selected', 'false');
			});
			tab.setAttribute('aria-selected', 'true');
			playClip(tab.getAttribute('data-video'));
		});
	});

	var viewport = document.querySelector('.logo-slider-viewport');
	var prevBtn = document.querySelector('.logo-slider-btn.is-prev');
	var nextBtn = document.querySelector('.logo-slider-btn.is-next');
	var thumb = document.querySelector('.logo-slider-thumb');
	var track = document.querySelector('.logo-slider-rail');

	if (viewport && prevBtn && nextBtn && thumb && track) {
		function maxScroll() {
			return Math.max(0, viewport.scrollWidth - viewport.clientWidth);
		}

		function updateThumb() {
			var max = maxScroll();
			var ratio = max ? viewport.scrollLeft / max : 0;
			var travel = Math.max(0, track.clientWidth - thumb.offsetWidth);
			thumb.style.transform = 'translate(' + (ratio * travel) + 'px, -50%)';
		}

		function step(dir) {
			viewport.scrollBy({
				left: dir * Math.round(viewport.clientWidth * 0.55),
				behavior: reduce ? 'auto' : 'smooth'
			});
		}

		prevBtn.addEventListener('click', function () {
			step(-1);
		});
		nextBtn.addEventListener('click', function () {
			step(1);
		});
		viewport.addEventListener('scroll', updateThumb, { passive: true });
		window.addEventListener('resize', updateThumb);
		updateThumb();

		var paused = false;
		var wrap = document.querySelector('.logo-slider');
		function pause() {
			paused = true;
		}
		function resume() {
			paused = false;
		}
		if (wrap) {
			wrap.addEventListener('mouseenter', pause);
			wrap.addEventListener('mouseleave', resume);
			wrap.addEventListener('focusin', pause);
			wrap.addEventListener('focusout', resume);
		}
		prevBtn.addEventListener('mouseenter', pause);
		nextBtn.addEventListener('mouseenter', pause);

		function autoSlide() {
			if (!paused && !reduce) {
				var max = maxScroll();
				if (max > 1) {
					viewport.scrollLeft += 0.55;
					if (viewport.scrollLeft >= max - 1) {
						viewport.scrollLeft = 0;
					}
				}
			}
			requestAnimationFrame(autoSlide);
		}
		if (!reduce) {
			requestAnimationFrame(autoSlide);
		}
	}

	document.querySelectorAll('.story-media video').forEach(function (clip) {
		clip.muted = true;
		clip.loop = true;
		var card = clip.closest('.story-media');
		if (!card) {
			return;
		}
		card.addEventListener('mouseenter', function () {
			var play = clip.play();
			if (play && play.catch) {
				play.catch(function () {});
			}
		});
		card.addEventListener('mouseleave', function () {
			clip.pause();
		});
	});

	var mapEl = document.getElementById('epc-map');
	if (mapEl && window.L) {
		var points = {
			epc: [39.6168, -75.0732],
			amazon: [39.791, -75.355],
			walmart: [40.211, -74.68],
			tiktok: [40.575, -74.501]
		};
		var map = L.map('epc-map', {
			scrollWheelZoom: false,
			zoomControl: true
		});

		L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
			maxZoom: 18,
			attribution: '&copy; OpenStreetMap &copy; CARTO'
		}).addTo(map);

		function hubIcon(color) {
			return L.divIcon({
				className: 'epc-pin',
				html: '<span style="background:' + color + '"></span>',
				iconSize: [22, 22],
				iconAnchor: [11, 22]
			});
		}

		// Brand-themed colors per marketplace hub.
		var hubColors = {
			epc: '#2563eb',
			amazon: '#FF9900',
			walmart: '#0071CE',
			tiktok: '#FE2C55'
		};

		var markers = {
			epc: L.marker(points.epc, { icon: hubIcon(hubColors.epc) }).addTo(map).bindPopup(
				'<strong>ELITE PREP CENTER (EPC)</strong><br>1736 Dutch Mill Road, Franklinville, NJ 08322'
			),
			amazon: L.marker(points.amazon, { icon: hubIcon(hubColors.amazon) }).addTo(map),
			walmart: L.marker(points.walmart, { icon: hubIcon(hubColors.walmart) }).addTo(map),
			tiktok: L.marker(points.tiktok, { icon: hubIcon(hubColors.tiktok) }).addTo(map)
		};

		function routeLine(dest, color) {
			return L.polyline([points.epc, points[dest]], {
				color: color,
				weight: 3,
				opacity: 0.9,
				dashArray: '8 10'
			}).addTo(map);
		}
		routeLine('amazon', hubColors.amazon);
		routeLine('walmart', hubColors.walmart);
		routeLine('tiktok', hubColors.tiktok);

		map.fitBounds([points.epc, points.amazon, points.walmart, points.tiktok], {
			padding: [40, 40]
		});
		window.setTimeout(function () {
			map.invalidateSize();
		}, 250);

		document.querySelectorAll('.map-hub').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var id = btn.getAttribute('data-hub');
				if (markers[id] && points[id]) {
					map.flyTo(points[id], 11, { duration: reduce ? 0 : 0.8 });
				}
			});
		});

		['amazon', 'walmart', 'tiktok'].forEach(function (id) {
			markers[id].on('click', function () {
				var btn = document.querySelector('.map-hub[data-hub="' + id + '"]');
				if (btn) {
					btn.click();
				}
			});
		});
	}

	// Click-to-expand hub details. Runs independently of Leaflet so it
	// works even when the map tiles or library fail to load.
	var mapHubs = document.querySelectorAll('.map-hub');
	var mapDetail = document.getElementById('map-detail');
	if (mapHubs.length && mapDetail) {
		var d = {
			img: mapDetail.querySelector('[data-detail-img]'),
			photo: mapDetail.querySelector('[data-detail-photo]'),
			fallback: mapDetail.querySelector('[data-detail-fallback]'),
			market: mapDetail.querySelector('[data-detail-market]'),
			name: mapDetail.querySelector('[data-detail-name]'),
			addr: mapDetail.querySelector('[data-detail-addr]'),
			miles: mapDetail.querySelector('[data-detail-miles]'),
			drive: mapDetail.querySelector('[data-detail-drive]'),
			tz: mapDetail.querySelector('[data-detail-tz]'),
			time: mapDetail.querySelector('[data-detail-localtime]')
		};
		var detailTimer = null;
		var activeHub = null;

		function localTime(tzName) {
			try {
				return new Date().toLocaleTimeString('en-US', {
					timeZone: tzName,
					hour: 'numeric',
					minute: '2-digit',
					hour12: true
				});
			} catch (err) {
				return '';
			}
		}

		function openDetail(btn) {
			var tzName = btn.getAttribute('data-tzname') || 'America/New_York';
			var name = btn.getAttribute('data-name') || '';
			var photo = btn.getAttribute('data-photo') || '';
			mapDetail.style.setProperty('--hub-color', btn.getAttribute('data-color') || '#facc15');

			// Real building photo if available; otherwise show the logo fallback panel.
			if (d.photo && d.fallback) {
				if (photo) {
					d.photo.src = photo;
					d.photo.alt = name;
					d.photo.hidden = false;
					d.fallback.hidden = true;
				} else {
					d.photo.hidden = true;
					d.fallback.hidden = false;
				}
			}
			if (d.img) {
				d.img.src = btn.getAttribute('data-img') || '';
				d.img.alt = name;
			}
			if (d.market) { d.market.textContent = btn.getAttribute('data-market') || ''; }
			if (d.name) { d.name.textContent = name; }
			if (d.addr) { d.addr.textContent = btn.getAttribute('data-addr') || ''; }
			if (d.miles) { d.miles.textContent = btn.getAttribute('data-miles') || ''; }
			if (d.drive) { d.drive.textContent = btn.getAttribute('data-drive') || ''; }
			if (d.tz) { d.tz.textContent = btn.getAttribute('data-tz') || ''; }

			function tick() {
				if (d.time) { d.time.textContent = localTime(tzName) || '—'; }
			}
			tick();
			if (detailTimer) { window.clearInterval(detailTimer); }
			detailTimer = window.setInterval(tick, 20000);

			mapDetail.hidden = false;
			requestAnimationFrame(function () {
				mapDetail.classList.add('is-open');
			});
		}

		function closeDetail() {
			mapDetail.classList.remove('is-open');
			if (detailTimer) { window.clearInterval(detailTimer); detailTimer = null; }
			if (activeHub) { activeHub.setAttribute('aria-expanded', 'false'); activeHub = null; }
			mapHubs.forEach(function (h) { h.classList.remove('is-active'); });
			window.setTimeout(function () { mapDetail.hidden = true; }, 260);
		}

		mapHubs.forEach(function (btn) {
			btn.addEventListener('click', function () {
				if (activeHub === btn && mapDetail.classList.contains('is-open')) {
					closeDetail();
					return;
				}
				mapHubs.forEach(function (h) {
					h.classList.remove('is-active');
					h.setAttribute('aria-expanded', 'false');
				});
				btn.classList.add('is-active');
				btn.setAttribute('aria-expanded', 'true');
				activeHub = btn;
				openDetail(btn);
			});
		});

		mapDetail.querySelectorAll('[data-detail-close]').forEach(function (el) {
			el.addEventListener('click', closeDetail);
		});
	}

	var popup = document.getElementById('epc-popup');
	if (popup) {
		window.setTimeout(function () {
			popup.hidden = false;
			requestAnimationFrame(function () {
				popup.classList.add('is-open');
			});
			document.body.classList.add('popup-open');
			var closeBtn = popup.querySelector('.epc-popup-close');
			if (closeBtn) {
				closeBtn.focus();
			}
		}, 8000);

		function closePopup() {
			popup.classList.remove('is-open');
			document.body.classList.remove('popup-open');
			window.setTimeout(function () {
				popup.hidden = true;
			}, 280);
		}

		popup.querySelectorAll('[data-popup-close]').forEach(function (el) {
			el.addEventListener('click', closePopup);
		});
		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && popup.classList.contains('is-open')) {
				closePopup();
			}
		});
	}

	var search = document.getElementById('pricing-search') || document.getElementById('pricing-search');
	var cards = document.querySelectorAll('.rate-card');
	var filters = document.querySelectorAll('.pricing-filters button, .pricing-filters button');
	var empty = document.querySelector('.pricing-empty, .pricing-empty');
	var activeType = 'all';

	function filterRates() {
		var q = search ? search.value.toLowerCase().trim() : '';
		var shown = 0;
		cards.forEach(function (card) {
			var typeOk = activeType === 'all' || card.getAttribute('data-type') === activeType;
			var textOk = !q || (card.getAttribute('data-search') || '').indexOf(q) !== -1;
			var on = typeOk && textOk;
			card.hidden = !on;
			if (on) {
				shown += 1;
			}
		});
		document.querySelectorAll('.rate-group').forEach(function (group) {
			var any = group.querySelectorAll('.rate-card:not([hidden])').length > 0;
			group.hidden = !any;
		});
		if (empty) {
			empty.hidden = shown > 0;
		}
	}

	if (cards.length) {
		filters.forEach(function (btn) {
			btn.addEventListener('click', function () {
				filters.forEach(function (item) {
					item.classList.remove('is-active');
				});
				btn.classList.add('is-active');
				activeType = btn.getAttribute('data-filter') || 'all';
				filterRates();
			});
		});
		if (search) {
			search.addEventListener('input', filterRates);
		}
	}

	// Brand case studies — click a logo tab to reveal its panel below
	var csTabs = Array.prototype.slice.call(document.querySelectorAll('[data-cs-primary] .cs-tab'));
	var csAllTabs = Array.prototype.slice.call(document.querySelectorAll('.cs-tab'));
	if (csTabs.length) {
		var csPanels = document.querySelectorAll('.cs-panel');
		var csActive = 0;

		function csSelect(index) {
			var total = csTabs.length;
			csActive = ((index % total) + total) % total;
			csAllTabs.forEach(function (tab) {
				var on = parseInt(tab.getAttribute('data-cs-index'), 10) === csActive;
				tab.classList.toggle('is-active', on);
				if (tab.hasAttribute('aria-selected')) {
					tab.setAttribute('aria-selected', on ? 'true' : 'false');
				}
			});
			csPanels.forEach(function (panel, i) {
				var on = i === csActive;
				panel.classList.toggle('is-active', on);
				panel.hidden = !on;
			});
		}

		csAllTabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				csSelect(parseInt(tab.getAttribute('data-cs-index'), 10));
			});
		});

		csTabs.forEach(function (tab) {
			tab.addEventListener('keydown', function (event) {
				if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
					event.preventDefault();
					csSelect(csActive + (event.key === 'ArrowRight' ? 1 : -1));
					csTabs[csActive].focus();
				}
			});
		});

		var csPrev = document.querySelector('[data-cs-prev]');
		var csNext = document.querySelector('[data-cs-next]');
		if (csPrev) {
			csPrev.addEventListener('click', function () {
				csSelect(csActive - 1);
			});
		}
		if (csNext) {
			csNext.addEventListener('click', function () {
				csSelect(csActive + 1);
			});
		}
	}

	document.querySelectorAll('[data-ob-toggle]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var card = btn.closest('.ob-card');
			var panel = card ? card.querySelector('[data-ob-panel]') : null;
			if (!card || !panel) {
				return;
			}
			var open = card.classList.contains('is-open');
			card.classList.toggle('is-open', !open);
			btn.setAttribute('aria-expanded', open ? 'false' : 'true');
			panel.hidden = open;
		});
	});

	var blogCategory = document.querySelector('[data-blog-category]');
	if (blogCategory) {
		blogCategory.addEventListener('change', function () {
			if (blogCategory.value) {
				window.location.href = blogCategory.value;
			}
		});
	}
})();
