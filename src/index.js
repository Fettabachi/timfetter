import "../css/style.scss";
import CheckIsTouchDevice from "./modules/CheckIsTouchDevice";
import CheckBrowser from "./modules/CheckBrowser";
import SkipLinkFocusFix from "./modules/SkipLinkFocusFix";
import ToggleNavMenu from "./modules/ToggleNavMenu";
import A11yDialog from "./modules/A11yDialog"

// const handleOnPageLinks = new HandleOnPageLinks()
const checkIsTouchDevice = new CheckIsTouchDevice()
const checkBrowser = new CheckBrowser()
const skipLinkFocusFix = new SkipLinkFocusFix()
const toggleNavMenu = new ToggleNavMenu()
const a11yDialog = new A11yDialog()

// Allow new JS and CSS to load in browser without a traditional page refresh
if (module.hot) {
    module.hot.accept();
}
