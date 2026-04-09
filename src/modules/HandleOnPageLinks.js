class HandleOnPageLinks {
	constructor() {
		this.handleOnPageLinks();
	}

	handleOnPageLinks() {
		const links = Array.from(
			document.querySelectorAll('a[href*="#"]:not([href="#"])')
		);
		const headerHeight = document.querySelector("#masthead").offsetHeight;

		links.forEach((link) => {
			link.addEventListener("click", function (e) {
				e.preventDefault(); // prevent default action immediately

				if (
					location.pathname.replace(/^\//, "") ===
						this.pathname.replace(/^\//, "") &&
					location.hostname === this.hostname
				) {
					let target = document.querySelector(this.hash);
					target = target
						? target
						: document.querySelector("[name=" + this.hash.slice(1) + "]");
					if (target) {
						window.requestAnimationFrame(() => {
							window.scrollTo({
								top: target.offsetTop - headerHeight,
								behavior: "smooth", // let CSS handle the scrolling
							});
						});
						window.history.pushState(null, null, " "); // remove hash from URL
					}
				}
			});
		});
	}
}

export default HandleOnPageLinks;
