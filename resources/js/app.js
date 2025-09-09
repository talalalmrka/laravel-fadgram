import accordion from "fadgram-ui/alpine/accordion";
import "./carousel";
import "./tabs";
import "./quote-images-picker";
import { NavbarTransparentTop } from "./navbar-transparent-top";
import { initFadgramUI } from "fadgram-ui/helpers";
import Toast from "fadgram-ui/helpers/toast";
document.addEventListener("livewire:navigated", () => {
    initFadgramUI();
    NavbarTransparentTop.init();
});
let toastListener = null;
document.addEventListener("livewire:init", () => {
    if (!toastListener) {
        toastListener = Livewire.on("toast", (event) => {
            const data = event[0];
            Toast.make(data.message, data.options);
        });
    }
});
