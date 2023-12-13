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
            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
    </svg>
</template>
   
        