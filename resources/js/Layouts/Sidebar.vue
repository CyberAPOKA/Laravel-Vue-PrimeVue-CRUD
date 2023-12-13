<template>
    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
        aria-controls="sidebar-multi-level-sidebar" type="button"
        class="inline-flex items-center p-2 mt-2 ml-3 text-sm  rounded-lg sm:hidden justify-center hover:bg-[var(--surface-400)]">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="sidebar-multi-level-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-[var(--surface-50)] text-[var(--text-color)]">
            <ul class="space-y-2 font-medium">
                <li>
                    <Link :href="route('welcome')" :active="route().current('welcome')"
                        class="w-full flex items-center p-2 text-[var(--text-color)] rounded-lg hover:bg-[var(--surface-400)]">
                    <Home />
                    <span class="ml-4 whitespace-nowrap">Home</span>
                    </Link>
                </li>
                <li>
                    <button @click="openCreateUserModal"
                        class="w-full flex items-center p-2 text-[var(--text-color)] rounded-lg hover:bg-[var(--surface-400)]">
                        <AddUser />
                        <span class="ml-4 whitespace-nowrap">Usuário</span>
                    </button>
                </li>
                <li>
                    <button @click="openThemeModal"
                        class="w-full flex items-center p-2 text-[var(--text-color)] rounded-lg hover:bg-[var(--surface-400)]">
                        <Paint />
                        <span class="ml-4 whitespace-nowrap">Temas</span>
                    </button>
                </li>
                <li>
                    <Link :href="route('logs')"
                        class="w-full flex items-center p-2 text-[var(--text-color)] rounded-lg hover:bg-[var(--surface-400)]">
                    <Logs />
                    <span class="ml-4 whitespace-nowrap">Logs</span>
                    </Link>
                </li>
                <li>
                    <button id="dropdownExport" data-dropdown-toggle="dropdown" type="button"
                        class="flex justify-between items-center w-full p-2 text-[var(--text-color)] rounded-lg hover:bg-[var(--surface-400)]">
                        <div class="flex items-center">
                            <Export />
                            <span class="text-[var(--text-color)] ml-4 whitespace-nowrap">Exportar para</span>
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </div>

                    </button>

                    <div id="dropdown" class="z-10 hidden bg-[var(--surface-50)] divide-y rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-[var(--text-color)]" aria-labelledby="dropdownExport">
                            <li>
                                <a :href="route('export.excel')" download
                                    class="w-full flex items-center gap-4 p-2 text-[var(--text-color)] rounded-lg hover:bg-[var(--surface-400)]">
                                    <Excel />
                                    <span class="whitespace-nowrap font-bold text-xl">Excel</span>
                                </a>
                            </li>

                            <li>
                                <a :href="route('export.excel')" download
                                    class="w-full flex items-center gap-4 p-2 rounded-lg hover:bg-[var(--surface-400)] mt-2">
                                    <Pdf />
                                    <span class="whitespace-nowrap font-bold text-xl text-[var(--text-color)]">PDF</span>
                                </a>
                            </li>
                        </ul>
                    </div>


                </li>
            </ul>
        </div>
    </aside>
</template>
<script setup>
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";
import { Link } from '@inertiajs/vue3';
import AddUser from '@/Svgs/AddUser.vue';
import Paint from '@/Svgs/Paint.vue';
import Home from '@/Svgs/Home.vue';
import Logs from '@/Svgs/Logs.vue';
import Export from '@/Svgs/Export.vue';
import Excel from '@/Svgs/Excel.vue';
import Pdf from '@/Svgs/Pdf.vue';

onMounted(() => {
    initFlowbite();
});

const emit = defineEmits(['openCreateUserModal', 'openThemeModal']);

const openCreateUserModal = () => {
    emit('openCreateUserModal');
};

const openThemeModal = () => {
    emit('openThemeModal');
};
</script>