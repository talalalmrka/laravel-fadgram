<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import EventBus from '@/types/event-bus';
import axios from 'axios';
import { route } from 'ziggy-js';
import Toast from "fadgram-ui/helpers/toast";
import type { Block } from '@/types';
import {
    RenderBlock
} from '@/components';
import { useForm } from '@inertiajs/vue3';


const isOpen = ref(false);
const form = useForm<Record<string, any>>({
    name: '',
    icon: '',
    block: undefined,
})

function open(incoming: Block) {
    isOpen.value = true;

    form.name = incoming.type ?? 'New pattern'
    form.icon = incoming.icon ?? 'bi-x-diamond-fill'
    form.block = JSON.parse(JSON.stringify(incoming)) as Block
}

function close() {
    isOpen.value = false;
    reset();
}

function reset() {
    form.reset()
}

onMounted(() => {
    EventBus.on('savePattern', open);
});
function submit() {
    form.post(route('patterns.store'), {
        preserveScroll: true,
        showProgress: false,
        onSuccess: (page) => {
            // toast success
            const flashes = page.props.flash;
            if (flashes && Object.prototype.hasOwnProperty.call(flashes, 'save')) {
                const successMessage = (flashes as Record<string, string | undefined>)['save']
                if (successMessage) {
                    close()
                    Toast.success(successMessage, 'bottom-start');
                }
            }

            // Toast error
            const errs = page.props.errors;
            if (errs && !Object.prototype.hasOwnProperty.call(errs, 'save')) {
                const errorMessage = errs['save'];
                if (errorMessage) {
                    Toast.error(errorMessage, 'bottom-start');
                }
            }

        },
    });
}


</script>

<template>
    <div v-show="isOpen" class="modal-backdrop show"></div>

    <div v-show="isOpen" class="modal fade show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save pattern</h5>
                    <button type="button" class="btn-close" @click="close">
                        <i class="icon bi-x-lg"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="col">
                            <fg-input v-model="form.name" label="name" />
                            <p v-if="form.errors.name" class="text-sm text-danger mt-1"
                                v-for="(err, i) in form.errors.name" :key="i">{{ err }}</p>
                        </div>

                        <div class="col">
                            <fg-icon-picker v-model="form.icon" label="Icon" />

                        </div>
                        <div v-if="form.block" class="">
                            <render-block :block="form.block" />
                        </div>
                    </div>
                </div>

                <div class="modal-footer flex-space-2 justify-between">
                    <button type="button" class="btn btn-secondary" @click="close"
                        :disabled="form.processing">Cancel</button>
                    <button type="button" class="btn btn-primary" @click="submit" :disabled="form.processing">
                        <span v-if="!form.processing">Save</span>
                        <fg-loader v-else dots-move />
                    </button>
                </div>
            </div><!-- Modal Content -->
        </div><!-- Modal Dialog -->
    </div><!-- Modal -->
</template>
