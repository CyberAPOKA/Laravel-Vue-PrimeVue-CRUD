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
            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
    </svg>
</template>