import 'a11y-dialog'
// import A11yDialog from 'a11y-dialog'

class A11yDialog {
    constructor() {
        this.openDialogButton = document.querySelectorAll(".btn--view-more");
        this.closeDialogButton = document.querySelectorAll(".dialog-close");
        this.dialogOverlay = document.querySelectorAll(".dialog-overlay");
        this.isDialogOpen = false;
        this.events();
    }

    events() {
        this.openDialogButton.forEach((el) => {
            el.addEventListener("click", (e) => {
                e.preventDefault();
                this.preventBodyScroll();
            });
        });

        this.closeDialogButton.forEach((el) => {
            el.addEventListener("click", (e) => {
                e.preventDefault();
                this.allowBodyScroll();
            });
        });

        this.dialogOverlay.forEach((el) => {
            el.addEventListener("click", (e) => {
                e.preventDefault();
                this.allowBodyScroll();
            });
        });

        document.addEventListener("keydown", (e) => this.keyPressDispatcher(e));
    }

    preventBodyScroll() {
        document.body.classList.add("body-no-scroll");
        this.isDialogOpen = true;
        return false;
    }

    allowBodyScroll() {
        document.body.classList.remove("body-no-scroll");
        this.isDialogOpen = false;
        return false;
    }

    keyPressDispatcher(e) {
        if (e.key === "Escape" && this.isDialogOpen) {
            this.allowBodyScroll();
        }
    }
}

export default A11yDialog;
