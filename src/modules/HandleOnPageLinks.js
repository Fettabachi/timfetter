class HandleOnPageLinks {
	constructor() {
		this.header = document.querySelector("#masthead");
		this.headerHeight = this.header ? this.header.offsetHeight : 0;

		this.handleOnPageLinks();
		this.handleInitialHash();
	}

	getTarget(hash) {
		if (!hash) {
			return null;
		}

		const id = hash.slice(1);

		return (
			document.querySelector(hash) ||
			document.querySelector(`[name="${CSS.escape(id)}"]`)
		);
	}

	isSamePageLink(link) {
		return (
			location.pathname.replace(/^\//, "") ===
				link.pathname.replace(/^\//, "") && location.hostname === link.hostname
		);
	}

	scrollToTarget(target) {
		if (!target) {
			return;
		}

		window.requestAnimationFrame(() => {
			const targetTop = target.getBoundingClientRect().top + window.pageYOffset;

			window.scrollTo({
				top: targetTop - this.headerHeight,
				behavior: "smooth",
			});
		});
	}

	handleOnPageLinks() {
		const links = Array.from(
			document.querySelectorAll('a[href*="#"]:not([href="#"])')
		);

		links.forEach((link) => {
			link.addEventListener("click", (e) => {
				if (!this.isSamePageLink(link)) {
					return;
				}

				const target = this.getTarget(link.hash);

				if (!target) {
					return;
				}

				e.preventDefault();

				this.scrollToTarget(target);

				// Optional: keep URL clean after same-page scroll.
				window.history.pushState(
					null,
					"",
					window.location.pathname + window.location.search
				);
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

		// Let the browser land first, then correct for the fixed header.
		window.requestAnimationFrame(() => {
			this.scrollToTarget(target);
		});
	}
}

export default HandleOnPageLinks;
