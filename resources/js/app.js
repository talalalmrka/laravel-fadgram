// import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
// import sort from '@alpinejs/sort'
import accordion from 'fadgram-ui/alpine/accordion';
import './carousel'
import './tabs';
import { NavbarTransparentTop } from './navbar-transparent-top';

// Alpine.plugin(sort)
// Alpine.plugin(accordion)

import { initFadgramUI } from "fadgram-ui/helpers";
import Toast from "fadgram-ui/helpers/toast";
document.addEventListener('livewire:navigated', () => {
    initFadgramUI();
    NavbarTransparentTop.init();
});
let toastListener = null;
let openNewTabListener = null;
document.addEventListener('livewire:init', () => {
    if (!toastListener) {
        toastListener = Livewire.on('toast', (event) => {
            const data = event[0];
            Toast.make(data.message, data.options);
        });
    }
});
// Livewire.start()
//import "./textarea-direction";
