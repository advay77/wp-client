(function () {
	var toggle = document.querySelector('.menu-toggle');
	var nav = document.querySelector('.primary-nav') || document.getElementById('site-navigation');
	var header = document.querySelector('.site-header');
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (toggle && nav) {
		function closeAllMegas() {
			nav.querySelectorAll('.has-mega.is-open').forEach(function (el) {
				el.classList.remove('is-open');
			});
		}

		function setOpen(open) {
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			document.body.classList.toggle('nav-open', open);
			if (!open) {
				closeAllMegas();
			}
		}

		toggle.addEventListener('click', function () {
			var willOpen = toggle.getAttribute('aria-expanded') !== 'true';
			if (willOpen) {
				closeAllMegas();
			}
			setOpen(willOpen);
		});

		window.addEventListener('resize', function () {
			if (window.matchMedia('(min-width: 768px)').matches) {
				setOpen(false);
			}
		});

		nav.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function (event) {
				if (!window.matchMedia('(max-width: 767px)').matches) {
					return;
				}
				/* Top-level mega accordion (Company / What we do / …). */
				if (link.classList.contains('nav-trigger')) {
					event.preventDefault();
					var item = link.closest('.has-mega');
					if (item) {
						var willOpen = !item.classList.contains('is-open');
						closeAllMegas();
						item.classList.toggle('is-open', willOpen);
					}
					return;
				}
				/* Nested What we do columns — expand in place; keep the drawer open. */
				if (link.classList.contains('mega-head')) {
					return;
				}
				setOpen(false);
			});
		});
	}

	document.querySelectorAll('.has-mega > .nav-trigger').forEach(function (link) {
		link.addEventListener('click', function (event) {
			if (!window.matchMedia('(min-width: 900px)').matches) {
				return;
			}
			var item = link.closest('.has-mega');
			if (!item) {
				return;
			}
			/* Keep mega open on click (same as other menus). Card / View all links still navigate. */
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

	/* Desktop: hovering another nav item clears click-open state so Company / What we do swap freely. */
	document.querySelectorAll('.primary-nav .has-mega').forEach(function (item) {
		item.addEventListener('mouseenter', function () {
			if (!window.matchMedia('(min-width: 900px)').matches) {
				return;
			}
			document.querySelectorAll('.primary-nav .has-mega.is-open').forEach(function (el) {
				if (el !== item) {
					el.classList.remove('is-open');
				}
			});
		});
	});

	/* Close open mega when clicking outside */
	document.addEventListener('click', function (event) {
		if (!window.matchMedia('(min-width: 900px)').matches) {
			return;
		}
		if (event.target.closest('.has-mega')) {
			return;
		}
		document.querySelectorAll('.has-mega.is-open').forEach(function (el) {
			el.classList.remove('is-open');
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
	var tabs = document.querySelectorAll('[data-hero-tab]');
	var heroHeading = document.getElementById('hero-heading');
	var heroLede = document.querySelector('[data-hero-lede]');
	var heroCopy = document.querySelector('[data-hero-copy]');

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

	function setHeroCopy(headline, body) {
		if (!heroHeading || !heroLede) {
			return;
		}
		function apply() {
			heroHeading.textContent = headline || '';
			heroLede.textContent = body || '';
			if (heroCopy) {
				heroCopy.classList.remove('is-switching');
			}
		}
		if (reduce || !heroCopy) {
			apply();
			return;
		}
		heroCopy.classList.add('is-switching');
		window.setTimeout(apply, 180);
	}

	function activateTab(tab) {
		tabs.forEach(function (item) {
			item.classList.remove('is-active');
			item.setAttribute('aria-selected', 'false');
		});
		tab.classList.add('is-active');
		tab.setAttribute('aria-selected', 'true');
		setHeroCopy(tab.getAttribute('data-headline'), tab.getAttribute('data-body'));
		playClip(tab.getAttribute('data-video'));
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
			if (tab.classList.contains('is-active')) {
				return;
			}
			activateTab(tab);
		});
	});

	/* Deep-link: /?channel=amazon|walmart|tiktok|dtc */
	(function () {
		if (!tabs.length) {
			return;
		}
		var params = new URLSearchParams(window.location.search);
		var channel = (params.get('channel') || '').toLowerCase();
		if (!channel) {
			return;
		}
		var match = Array.prototype.find.call(tabs, function (tab) {
			return tab.id === 'tab-' + channel;
		});
		if (match) {
			activateTab(match);
		}
	})();

	var viewport = document.querySelector('.logo-slider-viewport');
	var prevBtn = document.querySelector('.logo-slider-btn.is-prev');
	var nextBtn = document.querySelector('.logo-slider-btn.is-next');
	var thumb = document.querySelector('.logo-slider-thumb');
	var track = document.querySelector('.logo-slider-rail');

	if (viewport && prevBtn && nextBtn && thumb && track) {
		var list = viewport.querySelector('.logo-slider-list');
		/* Keep a float position — browsers truncate scrollLeft, so += 0.75 never moves. */
		var autoPos = 0;

		function maxScroll() {
			return Math.max(0, viewport.scrollWidth - viewport.clientWidth);
		}

		/* List is duplicated 3× — loop on one set width. */
		function loopWidth() {
			if (!list) {
				return Math.max(1, maxScroll());
			}
			return Math.max(1, Math.round(list.scrollWidth / 3));
		}

		function normalizeLoop() {
			var half = loopWidth();
			if (viewport.scrollLeft >= half * 2) {
				viewport.scrollLeft -= half;
			} else if (viewport.scrollLeft < half) {
				viewport.scrollLeft += half;
			}
			autoPos = viewport.scrollLeft;
		}

		function updateThumb() {
			var half = loopWidth();
			var pos = ((viewport.scrollLeft % half) + half) % half;
			var ratio = half ? pos / half : 0;
			var travel = Math.max(0, track.clientWidth - thumb.offsetWidth);
			thumb.style.transform = 'translate(' + (ratio * travel) + 'px, -50%)';
		}

		function step(dir) {
			viewport.scrollBy({
				left: dir * Math.max(180, Math.round(viewport.clientWidth * 0.4)),
				behavior: reduce ? 'auto' : 'smooth'
			});
			window.setTimeout(function () {
				normalizeLoop();
				updateThumb();
			}, reduce ? 0 : 420);
		}

		prevBtn.addEventListener('click', function () {
			step(-1);
		});
		nextBtn.addEventListener('click', function () {
			step(1);
		});
		viewport.addEventListener(
			'scroll',
			function () {
				/* During auto-slide, keep the float accumulator — don't snap it to integer scrollLeft. */
				if (!drag.active && !paused) {
					updateThumb();
					return;
				}
				normalizeLoop();
				updateThumb();
			},
			{ passive: true }
		);
		window.addEventListener('resize', function () {
			normalizeLoop();
			updateThumb();
		});

		function bootSlider() {
			autoPos = loopWidth();
			viewport.scrollLeft = autoPos;
			updateThumb();
		}
		bootSlider();
		if (list) {
			list.querySelectorAll('img').forEach(function (img) {
				if (!img.complete) {
					img.addEventListener('load', bootSlider, { once: true });
				}
			});
		}

		/* Drag-to-scroll on desktop only — touch uses native overflow scroll. */
		var drag = { active: false, startX: 0, startLeft: 0 };
		viewport.addEventListener('pointerdown', function (event) {
			if (event.pointerType !== 'mouse' || event.button !== 0) {
				return;
			}
			drag.active = true;
			drag.startX = event.clientX;
			drag.startLeft = viewport.scrollLeft;
			viewport.classList.add('is-dragging');
			pause();
			try {
				viewport.setPointerCapture(event.pointerId);
			} catch (err) {}
		});
		viewport.addEventListener('pointermove', function (event) {
			if (!drag.active) {
				return;
			}
			viewport.scrollLeft = drag.startLeft - (event.clientX - drag.startX);
			autoPos = viewport.scrollLeft;
			updateThumb();
		});
		function endDrag(event) {
			if (!drag.active) {
				return;
			}
			drag.active = false;
			viewport.classList.remove('is-dragging');
			normalizeLoop();
			updateThumb();
			window.setTimeout(resume, 800);
			try {
				viewport.releasePointerCapture(event.pointerId);
			} catch (err) {}
		}
		viewport.addEventListener('pointerup', endDrag);
		viewport.addEventListener('pointercancel', endDrag);
		viewport.addEventListener(
			'touchstart',
			function () {
				pause();
			},
			{ passive: true }
		);
		viewport.addEventListener(
			'touchend',
			function () {
				window.setTimeout(resume, 1200);
			},
			{ passive: true }
		);

		var paused = false;
		var wrap = document.querySelector('.logo-slider');
		function pause() {
			paused = true;
		}
		function resume() {
			paused = false;
			autoPos = viewport.scrollLeft;
		}
		if (wrap) {
			wrap.addEventListener('mouseenter', pause);
			wrap.addEventListener('mouseleave', resume);
			wrap.addEventListener('focusin', pause);
			wrap.addEventListener('focusout', resume);
		}
		prevBtn.addEventListener('mouseenter', pause);
		nextBtn.addEventListener('mouseenter', pause);

		/* Auto-move logos left → right. */
		var lastTs = 0;
		function autoSlide(ts) {
			if (!lastTs) {
				lastTs = ts;
			}
			var dt = Math.min(32, ts - lastTs);
			lastTs = ts;
			if (!paused && !reduce && !drag.active && maxScroll() > 1) {
				/* ~45px/sec — float accumulator avoids integer scrollLeft truncation. */
				autoPos += (dt / 1000) * 45;
				var half = loopWidth();
				while (autoPos >= half * 2) {
					autoPos -= half;
				}
				while (autoPos < half) {
					autoPos += half;
				}
				viewport.scrollLeft = autoPos;
				updateThumb();
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
		var muteBtn = card.querySelector('.story-mute');
		var isTouch = window.matchMedia('(hover: none), (max-width: 767px)').matches;

		function setMuteUi(muted) {
			card.classList.toggle('is-unmuted', !muted);
			if (muteBtn) {
				muteBtn.setAttribute('aria-pressed', muted ? 'false' : 'true');
			}
		}

		function freezeFirstFrame() {
			clip.pause();
			if (clip.readyState >= 2) {
				try {
					clip.currentTime = 0.001;
				} catch (err) {}
				return;
			}
			clip.addEventListener('loadeddata', function () {
				try {
					clip.currentTime = 0.001;
				} catch (err) {}
				clip.pause();
			}, { once: true });
		}

		function tryPlay() {
			var play = clip.play();
			if (play && play.catch) {
				play.catch(function () {});
			}
		}

		setMuteUi(true);

		if (isTouch) {
			/* Mobile: autoplay muted when visible — hover never fires. */
			if ('IntersectionObserver' in window) {
				var io = new IntersectionObserver(
					function (entries) {
						entries.forEach(function (entry) {
							if (entry.isIntersecting) {
								tryPlay();
							} else {
								clip.pause();
							}
						});
					},
					{ threshold: 0.35 }
				);
				io.observe(card);
			} else {
				tryPlay();
			}
		} else {
			freezeFirstFrame();
			card.addEventListener('mouseenter', function () {
				tryPlay();
			});
			card.addEventListener('mouseleave', function () {
				clip.pause();
				try {
					clip.currentTime = 0.001;
				} catch (err) {}
				clip.muted = true;
				setMuteUi(true);
			});
		}

		if (muteBtn) {
			muteBtn.addEventListener('click', function (event) {
				event.preventDefault();
				event.stopPropagation();
				clip.muted = !clip.muted;
				setMuteUi(clip.muted);
				if (!clip.muted) {
					tryPlay();
				}
			});
		}
	});

	/* MD feature videos — sound toggle shared across homepage + MD page. */
	(function () {
		var wraps = document.querySelectorAll('.success-media-video, .md-hero-video-wrap, .md-feature-video');
		if (!wraps.length) {
			return;
		}

		function syncMute(muted) {
			wraps.forEach(function (wrap) {
				var video = wrap.querySelector('video');
				var btn = wrap.querySelector('.md-video-mute');
				if (video) {
					video.muted = muted;
					if (!muted) {
						var play = video.play();
						if (play && play.catch) {
							play.catch(function () {});
						}
					}
				}
				wrap.classList.toggle('is-unmuted', !muted);
				if (btn) {
					btn.setAttribute('aria-pressed', muted ? 'false' : 'true');
					btn.setAttribute('aria-label', muted ? 'Turn sound on' : 'Mute');
				}
			});
		}

		wraps.forEach(function (wrap) {
			var video = wrap.querySelector('video');
			var btn = wrap.querySelector('.md-video-mute');
			if (!video) {
				return;
			}
			video.muted = true;
			video.setAttribute('playsinline', '');
			video.setAttribute('webkit-playsinline', '');
			var play = video.play();
			if (play && play.catch) {
				play.catch(function () {});
			}
			if (btn) {
				btn.addEventListener('click', function (event) {
					event.preventDefault();
					event.stopPropagation();
					syncMute(!video.muted);
				});
			}
		});
		syncMute(true);
	})();

	/* Mobile mega: nest Platforms / Services / Get started under What we do. */
	(function () {
		var mq = window.matchMedia('(max-width: 767px)');
		function bindMegaCols() {
			document.querySelectorAll('.mega-what .mega-col').forEach(function (col) {
				var head = col.querySelector('.mega-head');
				if (!head || head.dataset.megaBound === '1') {
					return;
				}
				head.dataset.megaBound = '1';
				head.addEventListener('click', function (event) {
					if (!mq.matches) {
						return;
					}
					event.preventDefault();
					event.stopPropagation();
					var open = !col.classList.contains('is-col-open');
					document.querySelectorAll('.mega-what .mega-col.is-col-open').forEach(function (other) {
						if (other !== col) {
							other.classList.remove('is-col-open');
						}
					});
					col.classList.toggle('is-col-open', open);
				});
			});
		}
		bindMegaCols();
		if (mq.addEventListener) {
			mq.addEventListener('change', bindMegaCols);
		}
	})();

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
			zoomControl: false
		});
		L.control.zoom({ position: 'bottomright' }).addTo(map);

		/* Esri dark gray — no API key (CARTO raster now watermarks without one). */
		L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
			maxZoom: 16,
			attribution: 'Tiles &copy; Esri'
		}).addTo(map);
		L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Reference/MapServer/tile/{z}/{y}/{x}', {
			maxZoom: 16,
			attribution: ''
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
			epc: '#9ca3af',
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
	/* Markup is only output on the front page; open after a short delay on every load. */
	if (popup) {
		window.setTimeout(function () {
			if (!popup.isConnected) {
				return;
			}
			popup.hidden = false;
			requestAnimationFrame(function () {
				popup.classList.add('is-open');
			});
			document.body.classList.add('popup-open');
			var closeBtn = popup.querySelector('.epc-popup-close');
			if (closeBtn) {
				closeBtn.focus();
			}
		}, 2500);

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

	var founderRotate = document.querySelector('[data-founder-rotate]');
	if (founderRotate && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		var founderPhotos = founderRotate.querySelectorAll('[data-founder-photo]');
		if (founderPhotos.length > 1) {
			var founderIndex = 0;
			window.setInterval(function () {
				founderPhotos[founderIndex].classList.remove('is-active');
				founderIndex = (founderIndex + 1) % founderPhotos.length;
				founderPhotos[founderIndex].classList.add('is-active');
			}, 2000);
		}
	}

	/* Pattern-style sticky partner pills + scroll spy */
	(function () {
		var root = document.querySelector('[data-partner-spy]');
		var pillsNav = document.querySelector('[data-partner-pills]');
		var dock = document.querySelector('[data-partner-dock]');
		if (!root || !pillsNav || !dock) {
			return;
		}

		var pills = pillsNav.querySelectorAll('.partner-pill');
		var markers = [
			{ id: 'services', el: document.getElementById('services') },
			{ id: 'fit-check', el: document.getElementById('fit-check') },
			{ id: 'testimonials', el: document.getElementById('testimonials') }
		].filter(function (item) {
			return item.el;
		});

		if (!markers.length || !pills.length) {
			return;
		}

		function spyOffset() {
			var header = document.querySelector('.site-header');
			return (header ? header.offsetHeight : 72) + Math.min(dock.offsetHeight || 72, 96) + 16;
		}

		function setActive(id) {
			pills.forEach(function (pill) {
				pill.classList.toggle('is-active', pill.getAttribute('data-spy-target') === id);
			});
		}

		function updateSpy() {
			var offset = spyOffset();
			var y = window.scrollY + offset;
			var active = markers[0].id;

			for (var i = 0; i < markers.length; i++) {
				var top = markers[i].el.getBoundingClientRect().top + window.scrollY;
				if (y >= top - 4) {
					active = markers[i].id;
				}
			}

			setActive(active);
		}

		var ticking = false;
		function onScroll() {
			if (ticking) {
				return;
			}
			ticking = true;
			window.requestAnimationFrame(function () {
				updateSpy();
				ticking = false;
			});
		}

		window.addEventListener('scroll', onScroll, { passive: true });
		window.addEventListener('resize', updateSpy);
		updateSpy();

		pills.forEach(function (pill) {
			pill.addEventListener('click', function (event) {
				var id = pill.getAttribute('data-spy-target');
				var target = document.getElementById(id);
				if (!target) {
					return;
				}
				event.preventDefault();
				var top = target.getBoundingClientRect().top + window.scrollY - spyOffset();
				window.scrollTo({
					top: Math.max(0, top),
					behavior: reduce ? 'auto' : 'smooth'
				});
				setActive(id);
			});
		});
	})();

	/* Fit section: Niche / Specification tabs */
	(function () {
		var tabs = document.querySelectorAll('[data-fit-tab]');
		var panels = document.querySelectorAll('[data-fit-panel]');
		if (!tabs.length || !panels.length) {
			return;
		}

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				var id = tab.getAttribute('data-fit-tab');
				tabs.forEach(function (item) {
					var on = item === tab;
					item.classList.toggle('is-active', on);
					item.setAttribute('aria-selected', on ? 'true' : 'false');
				});
				panels.forEach(function (panel) {
					var on = panel.getAttribute('data-fit-panel') === id;
					panel.classList.toggle('is-active', on);
					panel.hidden = !on;
				});
			});
		});
	})();

	/* Our Story — continuous photo marquee */
	(function () {
		var viewport = document.querySelector('[data-os-gallery]');
		if (!viewport) {
			return;
		}

		var track = viewport.querySelector('.os-gallery-track');
		if (!track) {
			return;
		}

		function maxScroll() {
			return Math.max(0, viewport.scrollWidth - viewport.clientWidth);
		}

		function loopWidth() {
			return Math.max(1, Math.round(track.scrollWidth / 3));
		}

		function normalizeLoop() {
			var half = loopWidth();
			if (viewport.scrollLeft >= half * 2) {
				viewport.scrollLeft -= half;
			} else if (viewport.scrollLeft < half) {
				viewport.scrollLeft += half;
			}
		}

		var paused = false;
		var drag = { active: false, startX: 0, startLeft: 0 };

		viewport.scrollLeft = loopWidth();

		viewport.addEventListener('mouseenter', function () {
			paused = true;
		});
		viewport.addEventListener('mouseleave', function () {
			paused = false;
		});
		viewport.addEventListener('focusin', function () {
			paused = true;
		});
		viewport.addEventListener('focusout', function () {
			paused = false;
		});

		viewport.addEventListener('pointerdown', function (event) {
			if (event.pointerType === 'mouse' && event.button !== 0) {
				return;
			}
			drag.active = true;
			paused = true;
			drag.startX = event.clientX;
			drag.startLeft = viewport.scrollLeft;
			viewport.classList.add('is-dragging');
			try {
				viewport.setPointerCapture(event.pointerId);
			} catch (err) {}
		});

		viewport.addEventListener('pointermove', function (event) {
			if (!drag.active) {
				return;
			}
			viewport.scrollLeft = drag.startLeft - (event.clientX - drag.startX);
		});

		function endDrag(event) {
			if (!drag.active) {
				return;
			}
			drag.active = false;
			paused = false;
			viewport.classList.remove('is-dragging');
			normalizeLoop();
			try {
				viewport.releasePointerCapture(event.pointerId);
			} catch (err) {}
		}

		viewport.addEventListener('pointerup', endDrag);
		viewport.addEventListener('pointercancel', endDrag);

		function autoSlide() {
			if (!paused && !reduce && !drag.active && maxScroll() > 1) {
				viewport.scrollLeft -= 0.65;
				normalizeLoop();
			}
			requestAnimationFrame(autoSlide);
		}

		if (!reduce) {
			requestAnimationFrame(autoSlide);
		}
	})();

	var mdSlider = document.querySelector('[data-md-slider]');
	var mdLegacySlider = document.querySelector('[data-md-legacy-slider]');

	function initMdFadeSlider(root, interval) {
		if (!root || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			return;
		}

		var slides = root.querySelectorAll('[data-md-slide]');
		if (slides.length <= 1) {
			return;
		}

		var slideIndex = 0;
		window.setInterval(function () {
			slides[slideIndex].classList.remove('is-active');
			slideIndex = (slideIndex + 1) % slides.length;
			slides[slideIndex].classList.add('is-active');
		}, interval);
	}

	initMdFadeSlider(mdSlider, 2800);
	initMdFadeSlider(mdLegacySlider, 3000);

	document.querySelectorAll('[data-ss-video]').forEach(function (wrap) {
		var video = wrap.querySelector('video');
		var playBtn = wrap.querySelector('.ss-video-play');
		if (!video || !playBtn) {
			return;
		}

		playBtn.addEventListener('click', function () {
			wrap.classList.add('is-playing');
			video.setAttribute('controls', 'controls');
			var playPromise = video.play();
			if (playPromise && typeof playPromise.catch === 'function') {
				playPromise.catch(function () {
					/* Autoplay policies — controls remain available. */
				});
			}
		});
	});

	document.querySelectorAll('[data-os-reveal]').forEach(function (block) {
		if (reduce) {
			block.classList.add('is-revealed');
			return;
		}

		if (!('IntersectionObserver' in window)) {
			block.classList.add('is-revealed');
			return;
		}
	});

	if (!reduce && 'IntersectionObserver' in window) {
		var revealBlocks = document.querySelectorAll('[data-os-reveal]:not(.is-revealed)');

		revealBlocks.forEach(function (block) {
			var direction = block.getAttribute('data-os-reveal');
			var isMobile = window.matchMedia('(max-width: 900px)').matches;
			var options =
				direction === 'right'
					? {
							threshold: isMobile ? 0.35 : 0.55,
							rootMargin: isMobile ? '0px 0px -8% 0px' : '0px 0px -6% 0px',
					  }
					: {
							threshold: isMobile ? 0.25 : 0.2,
							rootMargin: isMobile ? '0px 0px -15% 0px' : '0px 0px -30% 0px',
					  };

			var revealObserver = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (!entry.isIntersecting) {
						return;
					}

					entry.target.classList.add('is-revealed');
					revealObserver.unobserve(entry.target);
				});
			}, options);

			revealObserver.observe(block);
		});
	}
})();
