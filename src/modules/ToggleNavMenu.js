class ToggleNavMenu {
	constructor() {
		this.container = document.querySelector("#site-navigation");
		this.button = this.container.querySelector("#responsive-toggle");
		this.menu = this.container.querySelector("#menu-main-menu");
		this.menuItems = this.menu.querySelectorAll(".menu-item");
		this.isNavMenuOpen = false;
		this.events();
	}

	events() {
		this.button.addEventListener("click", () => {
			this.toggleMenu();
		});

		this.menuItems.forEach((el) => {
			el.addEventListener("click", (e) => {
				this.toggleMenu();
			});
		});

        document.addEventListener("keydown", (e) => this.keyPressDispatcher(e));
	}

	toggleMenu() {
		if (this.container.classList.contains("toggled") && this.isNavMenuOpen) {
			this.container.className = this.container.className.replace(" toggled", "");
			this.isNavMenuOpen = false;
		} else {
			this.container.classList.add("toggled");
			this.isNavMenuOpen = true;
		}
	}

	keyPressDispatcher(e) {
        if (e.key === "Escape" && this.isNavMenuOpen) {
            this.toggleMenu();
        }
    }
}

export default ToggleNavMenu;
