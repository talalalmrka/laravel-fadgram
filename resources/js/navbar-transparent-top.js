export class NavbarTransparentTop {
    constructor(navbar, options={}) {
        this.navbar = navbar;
        this.options = Object.assign(options, {
            distance: 0,
        });
        this.initialize();
    }
    addListeners() {
        document.addEventListener('scroll', () => this.toggle());
    }
    onBacktopClicked(e) {
        e.preventDefault();
        console.log('onBacktopClicked');
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    toggle() {
        // if (document.documentElement.scrollTop > this.navbar.offsetHeight) {
        if (document.documentElement.scrollTop > this.options.distance) {
            this.navbar.classList.add('scrolled');
        } else {
            this.navbar.classList.remove('scrolled');
        }
    }
    initialize() {
        this.addListeners();
        this.toggle();
    }

    static create(navabar) {
        if (!navabar.classList.contains('transparent-inited')) {
            new NavbarTransparentTop(navabar);
            navabar.classList.add('transparent-inited');
        }

    }

    static init() {
        document.querySelectorAll('.navbar-transparent-top').forEach(navbar => {
            NavbarTransparentTop.create(navbar);
        });
    }
}
