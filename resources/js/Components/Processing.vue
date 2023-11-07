<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);

watch(() => props.show, () => {
    if (props.show) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = null;
    }
});

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        'sm': 'sm:max-w-sm',
        'md': 'sm:max-w-md',
        'lg': 'sm:max-w-lg',
        'xl': 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
        '3xl': 'sm:max-w-3xl',
        '4xl': 'sm:max-w-4xl',
        '5xl': 'sm:max-w-5xl',
        '6xl': 'sm:max-w-6xl',
        '7xl': 'sm:max-w-7xl',
    }[props.maxWidth];
});
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" scroll-region>
                <transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0"
                    enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
                        <div class="absolute inset-0 bg-gray-950 opacity-75" />
                    </div>
                </transition>

                <transition enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div v-show="show"
                        class="h-screen flex items-center justify-center overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto"
                        :class="maxWidthClass">
                        <div class="loader">
                            <div class="container">
                                <div class="carousel">
                                    <div class="love"></div>
                                    <div class="love"></div>
                                    <div class="love"></div>
                                    <div class="love"></div>
                                    <div class="love"></div>
                                    <div class="love"></div>
                                    <div class="love"></div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="carousel">
                                    <div class="death"></div>
                                    <div class="death"></div>
                                    <div class="death"></div>
                                    <div class="death"></div>
                                    <div class="death"></div>
                                    <div class="death"></div>
                                    <div class="death"></div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="carousel">
                                    <div class="robots"></div>
                                    <div class="robots"></div>
                                    <div class="robots"></div>
                                    <div class="robots"></div>
                                    <div class="robots"></div>
                                    <div class="robots"></div>
                                    <div class="robots"></div>
                                </div>
                            </div>
                        </div>
                        <slot v-if="show" />
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
<style>
.loader {
    display: flex;
    position: relative;
    justify-items: center;
    align-items: center;
    gap: 1rem;
    height: 55px;
    width: 200px;
    overflow: hidden;
}

.container {
    width: 100%;
    display: flex;
    flex-direction: column;
    height: 200px;
    position: relative;
    align-items: center;
}

.carousel {
    display: flex;
    gap: 1rem;
    flex-direction: column;
    position: absolute;
    width: 100%;
    transform-origin: center;
    animation-delay: 2s;
}

.loader .container:nth-child(3) {
    justify-content: flex-start;
    justify-items: flex-start;
    animation: scroll-up 4s infinite ease-in-out;
    animation-delay: 3s;
}

.loader .container:nth-child(2) {
    justify-content: flex-end;
    justify-items: flex-end;
    animation: scroll-down 4s infinite ease-in-out;
    animation-delay: 3s;
}

.loader .container:nth-child(1) {
    justify-content: flex-end;
    justify-items: flex-end;
    animation: scroll-down 3s infinite ease-in-out;
    animation-delay: 3s;
}

.love {
    background: #010001;
    display: flex;
    width: 30px;
    height: 30px;
    position: relative;
    align-items: center;
    justify-content: center;
    left: 8px;
    margin: 0.8rem 4px;
    transform: rotate(45deg);
    animation-delay: 2s;
}

.love::before,
.love::after {
    content: '';
    position: absolute;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #010001;
}

.love::before {
    left: -16px;
}

.love::after {
    top: -16px;
}

.death {
    display: flex;
    width: 100%;
    height: 55px;
    position: relative;
    align-items: center;
    justify-content: center;
    animation: rotation 3s infinite ease-in-out;
    animation-delay: 1s;
}

.death:after {
    content: '';
    height: 63px;
    position: absolute;
    border-left: 12px solid #010001;
    transform: rotate(45deg);
    border-radius: 8px;
    top: -4px;
}

.death:before {
    content: '';
    height: 60px;
    position: absolute;
    border-left: 12px solid #010001;
    transform: rotate(-45deg);
}

.loader:hover {
    animation: none;
}

.robots {
    display: flex;
    width: 100%;
    height: 55px;
    justify-content: space-between;
    background-color: #010001;
    border-radius: 0 8px 8px;
    padding: 8px;
    animation-delay: 5s;
}

.robots::after {
    content: '';
    width: 12px;
    height: 12px;
    top: 0;
    left: 0;
    background-color: #ffffff;
    border-radius: 50%;
    animation-delay: 2s;
    animation: blink 0.5s 2 forwards;
}

.robots::before {
    content: '';
    width: 12px;
    height: 12px;
    top: 0;
    left: 0;
    background-color: #ffffff;
    border-radius: 50%;
    animation-delay: 2s;
    animation: blink 0.5s 2 forwards;
}

@keyframes scroll-up {
    0% {
        transform: translateY(0);
        /* filter: blur(0); */
    }

    30% {
        transform: translateY(-150%);
        /* filter: blur(10px); */
    }

    60% {
        transform: translateY(0);
        /* filter: blur(0px); */
    }
}

@keyframes scroll-down {
    0% {
        transform: translateY(0);
        /* filter: blur(0); */
    }

    30% {
        transform: translateY(150%);
        /* filter: blur(10px); */
    }

    60% {
        transform: translateY(0);
        /* filter: blur(0px); */
    }
}

@keyframes rotation {

    20%,
    100% {
        transform: rotate(180deg);
    }
}

@keyframes blink {
    0% {
        height: 0;
    }

    20% {
        height: 12px;
    }

    100% {
        height: 12px;
    }
}
</style>