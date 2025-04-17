export default function (Alpine) {
    Alpine.store('accordion', {
        activeItems: new Set(),

        toggle(id, multiple = false) {
            if (multiple) {
                this.activeItems.has(id)
                    ? this.activeItems.delete(id)
                    : this.activeItems.add(id);
            } else {
                this.activeItems = this.activeItems.has(id)
                    ? new Set()
                    : new Set([id]);
            }
        },

        isOpen(id) {
            return this.activeItems.has(id);
        }
    });

    Alpine.directive('accordion', (el, { modifiers, expression }, { evaluate }) => {
        const config = Object.assign({
            multiple: modifiers.includes('multiple'),
        }, evaluate(expression || '{}'));

        Alpine.bind(el, () => ({
            'x-data'() {
                return {
                    get store() {
                        return Alpine.store('accordion');
                    },
                    toggleItem(id) {
                        this.store.toggle(id, config.multiple);
                    },
                    isOpen(id) {
                        return this.store.isOpen(id);
                    }
                };
            },
            ':class'() {
                return 'bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg divide-y divide-gray-200 dark:divide-gray-700';
            }
        }));
    });

    Alpine.directive('accordion-item', (el, { expression }) => {
        const id = expression || crypto.randomUUID();
        el.setAttribute('data-accordion-id', id);
        el._accordionId = id;

        Alpine.bind(el, () => ({
            /*':class'() {
                return this.isOpen(id) ? 'bg-gray-50 dark:bg-gray-800' : '';
            }*/
        }));
    });

    Alpine.directive('accordion-header', (el, { expression }) => {
        const id = expression || el.closest('[data-accordion-id]')?._accordionId;
        if (!id) return;

        el.setAttribute('tabindex', '0');
        el.setAttribute('role', 'button');
        el.setAttribute('aria-controls', `accordion-body-${id}`);
        el.id = `accordion-header-${id}`;

        Alpine.bind(el, () => ({
            'x-init'() {
                // Inject chevron icon automatically if it doesn't exist
                if (!el.querySelector('.accordion-icon')) {
                    const icon = document.createElement('i');
                    icon.className = 'accordion-icon icon bi bi-chevron-down ml-2 transition-transform duration-300';
                    icon.setAttribute('x-bind:class', `{ 'rotate-180': isOpen('${id}') }`);
                    el.appendChild(icon);
                }
            },
            'x-on:click'() {
                this.toggleItem(id);
            },
            ':class'() {
                return 'flex items-center justify-between w-full px-3 py-2 cursor-pointer cursor-pointer text-gray-700 dark:text-gray-300';
            }
        }));
    });

    Alpine.directive('accordion-body', (el, { expression }) => {
        const id = expression || el.closest('[data-accordion-id]')?._accordionId;
        if (!id) return;

        el.id = `accordion-body-${id}`;
        el.setAttribute('role', 'region');
        el.setAttribute('aria-labelledby', `accordion-header-${id}`);

        Alpine.bind(el, () => ({
            'x-show'() {
                return this.isOpen(id);
            },
            'x-transition:enter'() {
                return 'transition-all ease-out duration-300';
            },
            'x-transition:enter-start'() {
                return 'opacity-0 max-h-0';
            },
            'x-transition:enter-end'() {
                return 'opacity-100 max-h-screen';
            },
            'x-transition:leave'() {
                return 'transition-all ease-in duration-200';
            },
            'x-transition:leave-start'() {
                return 'opacity-100 max-h-screen';
            },
            'x-transition:leave-end'() {
                return 'opacity-0 max-h-0';
            },
            ':class'() {
                return 'px-3 py-2 text-sm text-gray-600 dark:text-gray-400';
            }
        }));
    });
}
