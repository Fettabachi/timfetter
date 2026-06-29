class ResourceSectionNav {
	constructor() {
		this.navSelector = ".fu-resource-single__section-nav";
		this.toggleSelector = ".fu-resource-single__section-nav-toggle";

		this.init();
	}

	init() {
		const navs = Array.from(document.querySelectorAll(this.navSelector));

		navs.forEach((nav) => {
			const toggle = nav.querySelector(this.toggleSelector);

			if (!toggle) {
				return;
			}

			toggle.addEventListener("click", () => {
				const isOpen = nav.classList.toggle("is-open");

				toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
			});
		});
	}
}

export default ResourceSectionNav;
