import "../css/style.scss";
import HandleOnPageLinks from "./modules/HandleOnPageLinks";
import CheckIsTouchDevice from "./modules/CheckIsTouchDevice";
import CheckBrowser from "./modules/CheckBrowser";
import SkipLinkFocusFix from "./modules/SkipLinkFocusFix";

const handleOnPageLinks = new HandleOnPageLinks()
const checkIsTouchDevice = new CheckIsTouchDevice()
const checkBrowser = new CheckBrowser()
const skipLinkFocusFix = new SkipLinkFocusFix()

// Allow new JS and CSS to load in browser without a traditional page refresh
if (module.hot) {
    module.hot.accept();
}
