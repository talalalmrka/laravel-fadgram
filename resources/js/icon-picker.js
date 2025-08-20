import { icons } from "@iconify-json/bi";
document.addEventListener('alpine:init', () => {
    Alpine.data('IconPicker', ({model, value}) => ({
        open: false,
        model: model,
        value: value,
        search: '',
        get icons(){
            return Object.keys(icons.icons).map(icon => `bi-${icon}`);
        },
        page: 1,
        perPage: 25,
        get filteredIcons() {
            return this.icons.filter(icon => icon.toLowerCase().includes(this.search.toLowerCase()));
        },
        get pageIcons() {
            return this.filteredIcons.slice((this.page - 1) * this.perPage, this.page * this.perPage);
        },
        get pages() {
            return Math.ceil(this.filteredIcons.length / this.perPage);
        },
        toggle(){
            this.open = !this.open;
        },
        selectIcon(icon) {
            this.value = icon;
            this.$refs.input.value = icon;
            this.open = false;
            this.search = '';
            if (this.model) {
                if (typeof $wire !== 'undefined') {
                    $wire.set(this.model, this.icon);
                }
            }
        },
        inputChanged(evt) {
            this.value = evt.target.value;
        },
        clearIcon() {
            this.value = '';
            this.search = '';
        },
        clearSearch() {
            this.search = '';
        },
        iconName(icon) {
            return `bi-${icon}`;
        },
        prevPage() {
            if (this.page > 1) {
                this.page--;
            }
        },
        nextPage() {
            if (this.page < this.pages) {
                this.page++;
            }
        },
        getSvg(name){
            return icons.icons[name] && icons.icons[name].body ? `<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>${icons.icons[name].body}</svg>` : null
        },
        iconStyle(icon){
            const name = icon.replace('bi-', '');
            const iconSvg = this.getSvg(name);
            const iconUrl = iconSvg ? encodeURI(`data:image/svg+xml,${iconSvg}`) : '';
            return {
                '--svg': `url("${iconUrl}")`,
            };
        },
        get currentIconStyle(){
            return this.iconStyle(this.value);
        },
        init() {
            this.$nextTick(() => {
                if (this.icons.includes(this.$refs.input.value)) {
                    this.value = this.$refs.input.value;
                    this.page = Math.ceil((this.icons.indexOf(this.value) + 1) / this.perPage);
                }
                //console.log(this.value);
            });

            this.$watch('search', (value, oldValue) => {
                if (value !== oldValue) {
                    this.page = 1;
                }
            });
        }
    }));
});
