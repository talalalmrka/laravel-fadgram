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
import { uniqid } from '@/helpers';

interface PatternPayload {
    name: string;
    icon: string;
    block: Block | null;
}

const isOpen = ref(false);
const loading = ref(false);

// plain reactive state (no useForm)
const name = ref<string>('');
const icon = ref<string>('');
const block = ref<Block | null>(null);

// errors keyed by field name (e.g. { name: ['required'] })
const errors = reactive<Record<string, string[] | undefined>>({})

function open(incoming: Block) {
    isOpen.value = true;

    name.value = incoming.type ?? 'New pattern'
    icon.value = incoming.icon ?? 'bi-x-diamond-fill'
    block.value = JSON.parse(JSON.stringify(incoming)) as Block
    Object.keys(errors).forEach(k => delete errors[k]);
}

function close() {
    isOpen.value = false;
    reset();
}

function reset() {
    name.value = ''
    icon.value = ''
    block.value = null;
    Object.keys(errors).forEach(k => delete errors[k]);
}

onMounted(() => {
    EventBus.on('savePattern', open);
});
async function submit() {
    loading.value = true;
    try {
        const res = await axios.post(route('patterns.store', {
            name: name.value,
            icon: icon.value,
            block: block.value,
        }));

        const data = res?.data ?? {}
        console.log('res', res)
    } catch (e) {
        Toast.error(e, 'bottom-start')
    } finally {
        loading.value = false
    }
}
/* async function submitt() {
    loading.value = true;

    // clear previous errors
    Object.keys(errors).forEach(k => delete errors[k]);

    const payload: PatternPayload = {
        name: name.value,
        icon: icon.value,
        block: block.value,
    };

    try {
        const res = await axios.post(route('patterns.store', {
            name: name.value,
            icon: icon.value,
            block: block.value,
        }));

        const data = res?.data ?? {};

        // success flash (Laravel/Inertia-ish or custom shapes)
        if (data?.flash && Object.prototype.hasOwnProperty.call(data.flash, 'save')) {
            const m = (data.flash as Record<string, any>)['save'];
            if (m) Toast.success(m, 'bottom-start');
        } else if (data?.message) {
            Toast.success(data.message, 'bottom-start');
        } else if (data?.success) {
            if (typeof data.success === 'string') {
                Toast.success(data.success, 'bottom-start');
            } else if (data.message) {
                Toast.success(data.message, 'bottom-start');
            }
        }

        // optionally clear or close on success
        // close();
    } catch (err: unknown) {
        const e = err as any;

        if (e?.response?.status === 422) {
            // validation errors from Laravel: e.response.data.errors
            const validation = e.response.data?.errors ?? {};
            Object.entries(validation).forEach(([k, v]) => {
                // ensure it's an array of strings
                errors[k] = Array.isArray(v) ? v.map(String) : [String(v)];
            });
            Toast.error('Validation failed. Please check the form.', 'bottom-start');
        } else if (e?.response?.data) {
            const message =
                e.response.data?.flash?.save ??
                e.response.data?.message ??
                e.response.data?.error ??
                'An error occurred.';
            Toast.error(message, 'bottom-start');
        } else {
            Toast.error('Network error. Please try again.', 'bottom-start');
        }
    } finally {
        processing.value = false;
        loading.value = false;
    }
} */
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
                            <fg-input v-model="name" label="name" />
                            <p v-if="errors.name" class="text-sm text-danger mt-1" v-for="(err, i) in errors.name"
                                :key="i">{{ err }}</p>
                        </div>

                        <div class="col">
                            <fg-icon-picker v-model="icon" label="Icon" />
                            <p v-if="errors.icon" class="text-sm text-danger mt-1" v-for="(err, i) in errors.icon"
                                :key="i">{{ err }}</p>
                        </div>
                        <div v-if="block" class="">
                            <render-block :block="block" />
                        </div>
                    </div>
                </div>

                <div class="modal-footer flex-space-2 justify-between">
                    <button type="button" class="btn btn-secondary" @click="close" :disabled="loading">Cancel</button>
                    <button type="button" class="btn btn-primary" @click="submit" :disabled="loading">
                        <span v-if="!loading">Save</span>
                        <fg-loader v-else dots-move />
                    </button>
                </div>
            </div><!-- Modal Content -->
        </div><!-- Modal Dialog -->
    </div><!-- Modal -->
</template>
