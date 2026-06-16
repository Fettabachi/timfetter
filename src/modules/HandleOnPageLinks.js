class HandleOnPageLinks {
	constructor() {
		this.headerSelector = "#masthead";
		this.offset = 30;

		this.handleOnPageLinks();
		this.handleInitialHash();
	}

	getHeaderHeight() {
		const header = document.querySelector(this.headerSelector);

		return header ? header.offsetHeight : 0;
	}

	getTarget(hash) {
		if (!hash || hash === "#") {
			return null;
		}

		let id = hash.slice(1);

		try {
			id = decodeURIComponent(id);
		} catch (error) {
			// Keep the original id if decoding fails.
		}

		const targetById = document.getElementById(id);

		if (targetById) {
			return targetById;
		}

		if (typeof CSS === "undefined" || typeof CSS.escape !== "function") {
			return null;
		}

		return document.querySelector(`[name="${CSS.escape(id)}"]`);
	}

	isSamePageLink(link) {
		const url = new URL(link.href);

		return (
			url.origin === window.location.origin &&
			url.pathname.replace(/\/$/, "") ===
				window.location.pathname.replace(/\/$/, "") &&
			url.search === window.location.search
		);
	}

	scrollToTarget(target) {
		if (!target) {
			return;
		}

		window.requestAnimationFrame(() => {
			const headerHeight = this.getHeaderHeight();
			const targetTop = target.getBoundingClientRect().top + window.pageYOffset;
			const prefersReducedMotion = window.matchMedia(
				"(prefers-reduced-motion: reduce)"
			).matches;

			window.scrollTo({
				top: Math.max(targetTop - headerHeight - this.offset, 0),
				behavior: prefersReducedMotion ? "auto" : "smooth",
			});
		});
	}

	cleanCurrentUrl() {
		window.history.replaceState(
			null,
			"",
			window.location.pathname + window.location.search
		);
	}

	handleOnPageLinks() {
		const links = Array.from(
			document.querySelectorAll('a[href*="#"]:not([href="#"])')
		);

		links.forEach((link) => {
			link.addEventListener("click", (e) => {
				if (
					e.defaultPrevented ||
					e.metaKey ||
					e.ctrlKey ||
					e.shiftKey ||
					e.altKey ||
					(link.target && link.target !== "_self")
				) {
					return;
				}

				if (!this.isSamePageLink(link)) {
					return;
				}

				const target = this.getTarget(link.hash);

				if (!target) {
					return;
				}

				e.preventDefault();

				this.scrollToTarget(target);
				this.cleanCurrentUrl();
			});
		});
	}

	handleInitialHash() {
		if (!window.location.hash) {
			return;
		}

		const target = this.getTarget(window.location.hash);

		if (!target) {
			return;
		}

		// Let the browser land first, then correct for the sticky header.
		window.requestAnimationFrame(() => {
			window.requestAnimationFrame(() => {
				this.scrollToTarget(target);
			});
		});
	}
}

export default HandleOnPageLinks;