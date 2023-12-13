<script setup>
import { computed } from 'vue';

const props = defineProps({
    fillColor: {
        type: String,
        default: 'white',
    },
    strokeColor: {
        type: String,
        default: 'black',
    },
    strokeWidth: {
        type: Number,
        default: 1.5,
    },
    size: {
        type: String,
        default: '8',
    },
});

const fillColor = computed(() => {
    return {
        'black': '#0F172A',
        'white': 'white'
    }[props.fillColor];
});

const strokeColor = computed(() => {
    return {
        'black': '#0F172A',
        'white': 'white'
    }[props.strokeColor];
});

const strokeWidth = computed(() => {
    return {
        '1': '1',
        '1.5': '1.5',
        '2': '2',
        '2.5': '2.5',
        '133': '3',
    }[props.strokeWidth];
});

const size = computed(() => {
    return {
        '1': 'w-1 h-1',
        '2': 'w-2 h-2',
        '3': 'w-3 h-3',
        '4': 'w-4 h-4',
        '5': 'w-5 h-5',
        '6': 'w-6 h-6',
        '7': 'w-7 h-7',
        '8': 'w-8 h-8',
        '9': 'w-9 h-9',
        '10': 'w-10 h-10',
        '11': 'w-11 h-11',
        '12': 'w-12 h-12'
    }[props.size];
});
</script>
<template>
    <svg :class="size" fill="transparent" :stroke-width="strokeWidth" stroke="var(--surface-900)"
        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
    </svg>
</template>