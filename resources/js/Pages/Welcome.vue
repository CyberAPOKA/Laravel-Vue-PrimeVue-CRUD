<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import { usePrimeVue } from 'primevue/config';
import Dropdown from 'primevue/dropdown';
import Modal from '@/Components/Modal.vue';
import Processing from '@/Components/Processing.vue';
import Card from 'primevue/card';
import Toast from 'primevue/toast';
import Button from 'primevue/button';
import { useToast } from "primevue/usetoast";
import { useForm } from 'laravel-precognition-vue-inertia';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import moment from "moment";
import Sidebar from '@/Layouts/Sidebar.vue';
import EllipsisVertical from '@/Svgs/EllipsisVertical.vue';
import PencilSquare from '@/Svgs/PencilSquare.vue';
import Trash from '@/Svgs/Trash.vue';
import InputMask from 'primevue/inputmask';
import Tag from 'primevue/tag';
import TriStateCheckbox from 'primevue/tristatecheckbox';
import InputSwitch from 'primevue/inputswitch';

const toast = useToast();

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    users: Array
});

const users = computed(() => {
    return props.users.map(user => ({
        id: user.id,
        name: user.name,
        email: user.email,
        birthdate: new Date(user.birthdate),
        gender: user.gender,
        cpf: user.cpf,
        phone_number: user.phone_number,
        city: user.city,
        status: user.status,
        role: user.role,
        verified: user.email_verified_at != null,
    }));
});

// const filters = ref({
//     name: { value: null, matchMode: FilterMatchMode.CONTAINS },
//     email: { value: null, matchMode: FilterMatchMode.CONTAINS },
//     birthdate: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.DATE_IS }] },
// });

// atenção nos seguintes detalhes:
// filterDisplay="row"
// v-model:filters="filters"

const PrimeVue = usePrimeVue();

const theme = ref(localStorage.getItem('theme') || 'lara-light-purple');

onMounted(() => {
    PrimeVue.changeTheme('lara-light-purple', theme.value, 'theme-link');
});

const changeTheme = (newTheme) => {
    PrimeVue.changeTheme(theme.value, newTheme, 'theme-link');
    localStorage.setItem('theme', newTheme);
    theme.value = newTheme;
    toast.add({
        severity: 'info',
        summary: 'Info',
        detail: 'Tema alterado com Sucesso!',
        life: 3000
    });
};

const selectedUser = ref();
const groupedUsers = computed(() => {
    const groups = {};
    for (const user of props.users) {
        if (!groups[user.group]) {
            groups[user.group] = {
                label: user.group,
                items: []
            };
        }
        groups[user.group].items.push({
            label: user.name,
            value: user
        });
    }
    return Object.values(groups);
});

const showThemeModal = ref(false);
const openThemeModal = () => {
    showThemeModal.value = true;
};
const closeThemeModal = () => {
    showThemeModal.value = false;
};

const showCreateUserModal = ref(false);
const openCreateUserModal = () => {
    showCreateUserModal.value = true;
};
const closeCreateUserModal = () => {
    showCreateUserModal.value = false;
};

const genders = ['Masculino', 'Feminino', 'Outro'];

const formCreateUser = useForm('post', '/create-user', {
    name: '',
    email: '',
    gender: '',
    cpf: '',
    birthdate: '',
    gender: '',
    phone_number: '',
    city: '',
    status: '',
    role: '',
    email_verified_at: false,
    profile_photo_path: '',
});

const createUser = () => formCreateUser.submit({
    preserveScroll: true,
    onSuccess: () => {
        closeCreateUserModal();
        formCreateUser.reset();
        toast.add({
            severity: 'success',
            summary: 'Sucesso',
            detail: 'Usuário criado com Sucesso!',
            life: 3000
        });
    },
    onError: () => {
        toast.add({
            severity: 'error',
            summary: 'Erro',
            detail: 'Erro ao criar o usuário.',
            life: 3000
        });
    }
});

const user = ref();
const showUpdateUserModal = ref(false);
const formUpdateUser = ref(null);
const openUpdateUserModal = (userData) => {
    user.value = userData;
    // console.log(userData)
    formUpdateUser.value = useForm('put', `/update-user/${userData.id}`, {
        name: userData.name,
        email: userData.email,
        gender: userData.gender,
        cpf: userData.cpf,
        birthdate: userData.birthdate,
        phone_number: userData.phone_number,
        city: userData.city,
        status: userData.status,
        role: userData.role,
        email_verified_at: userData.verified,
        profile_photo_path: userData.profile_photo_path
    });
    showUpdateUserModal.value = true;
};

const closeUpdateUserModal = () => {
    showUpdateUserModal.value = false;
};

const updateUser = () => {
    formUpdateUser.value.submit({
        preserveScroll: true,
        onSuccess: () => {
            closeUpdateUserModal();
            toast.add({
                severity: 'success',
                summary: 'Sucesso',
                detail: 'Usuário atualizado com Sucesso!',
                life: 3000
            });
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Erro',
                detail: 'Erro ao atualizar o usuário.',
                life: 3000
            });
        }
    });
};

const showDeleteUserConfirmModal = ref(false);
const formDeleteUser = ref(null);
const openDeleteUserConfirmModal = (userData) => {
    user.value = userData;
    formDeleteUser.value = useForm('delete', `/delete-user/${userData.id}`, {
        id: userData.id,
    });
    showDeleteUserConfirmModal.value = true;
};
const closeDeleteUserConfirmModal = () => {
    showDeleteUserConfirmModal.value = false;
};

const deleteUser = () => {
    formDeleteUser.value.submit({
        preserveScroll: true,
        onSuccess: () => {
            closeDeleteUserConfirmModal();
            toast.add({
                severity: 'success',
                summary: 'Sucesso',
                detail: 'Usuário deletado com Sucesso!',
                life: 3000
            });
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Erro',
                detail: 'Erro ao deletar o usuário.',
                life: 3000
            });
        }
    });
};

const filters = ref();

const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        email: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
        name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
        phone_number: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
        birthdate: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.DATE_IS }] },
        city: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
        cpf: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
        status: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
        role: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
        gender: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
        verified: { value: null, matchMode: FilterMatchMode.EQUALS },

    };
};

initFilters();

const clearFilter = () => {
    initFilters();
};

const formatDate = (value) => {
    return value.toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
};

const formatCpf = (cpf) => {
    if (!cpf) return '';

    cpf = cpf.replace(/\D/g, '');

    cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');

    return cpf;
};

const formatPhoneNumber = (phone) => {
    if (!phone) return '';

    phone = phone.replace(/\D/g, '');

    phone = phone.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4');

    return phone;
};


const statuses = ref(['unqualified', 'qualified', 'new', 'negotiation', 'renewal', 'proposal']);

const getSeverityStatus = (status) => {
    switch (status) {
        case 'unqualified':
            return 'danger';

        case 'qualified':
            return 'success';

        case 'new':
            return 'info';

        case 'negotiation':
            return 'warning';

        case 'proposal':
            return 'primary';

        case 'renewal':
            return 'info';
    }
};

const roles = ref(['admin', 'user', 'editor', 'manager', 'guest']);

const getSeverityRole = (status) => {
    switch (status) {
        case 'admin':
            return 'danger';

        case 'user':
            return 'success';

        case 'editor':
            return 'info';

        case 'manager':
            return 'warning';

        case 'guest':
            return 'primary';
    }
};

const getSeverityGender = (gender) => {
    switch (gender) {
        case 'Masculino':
            return 'info';

        case 'Feminino':
            return 'danger';

        case 'Outro':
            return 'primary';
    }
};

const cities = ['New York', 'Rome', 'London', 'Istanbul', 'Paris']

const exportDeactivationTimer = ref(false);

const exportUsers = () => {
    exportDeactivationTimer.value = true;
    setTimeout(() => {
        exportDeactivationTimer.value = false;
    }, 3000);

    window.location.href = '/export';
};

</script>

<template>
    <Sidebar @openCreateUserModal="openCreateUserModal" @openThemeModal="openThemeModal" />
    <Toast />

    <Modal :show="showThemeModal" @close="closeThemeModal">
        <Card>
            <template #title>Escolha seu tema</template>
            <template #content>
                <!-- <h1 class="text-2xl mb-2">Lara</h1> -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-8">
                    <button @click="changeTheme('lara-light-purple')"
                        class="border border-[#8B5CF6] flex justify-between items-center h-8">
                        <span class="bg-[#ffffff] w-full h-full "></span>
                        <span class="bg-[#8B5CF6] w-full h-full"></span>
                    </button>

                    <button @click="changeTheme('lara-light-blue')"
                        class="border border-[#3B82F6] flex justify-between items-center h-8">
                        <span class="bg-[#ffffff] w-full h-full"></span>
                        <span class="bg-[#3B82F6] w-full h-full"></span>
                    </button>

                    <button @click="changeTheme('lara-light-indigo')"
                        class="border border-[#6366F1] flex justify-between items-center h-8">
                        <span class="bg-[#ffffff] w-full h-full"></span>
                        <span class="bg-[#6366F1] w-full h-full"></span>
                    </button>

                    <button @click="changeTheme('lara-light-teal')"
                        class="border border-[#10b981] flex justify-between items-center h-8">
                        <span class="bg-[#ffffff] w-full h-full"></span>
                        <span class="bg-[#10b981] w-full h-full"></span>
                    </button>

                    <button @click="changeTheme('lara-dark-purple')"
                        class="border border-[#a78bfa] flex justify-between items-center h-8">
                        <span class="bg-[#1f2937] w-full h-full "></span>
                        <span class="bg-[#a78bfa] w-full h-full"></span>
                    </button>

                    <button @click="changeTheme('lara-dark-blue')"
                        class="border border-[#60a5fa] flex justify-between items-center h-8">
                        <span class="bg-[#1f2937] w-full h-full "></span>
                        <span class="bg-[#60a5fa] w-full h-full"></span>
                    </button>

                    <button @click="changeTheme('lara-dark-indigo')"
                        class="border border-[#818cf8] flex justify-between items-center h-8">
                        <span class="bg-[#1f2937] w-full h-full "></span>
                        <span class="bg-[#818cf8] w-full h-full"></span>
                    </button>

                    <button @click="changeTheme('lara-dark-teal')"
                        class="border border-[#34d399] flex justify-between items-center h-8">
                        <span class="bg-[#1f2937] w-full h-full "></span>
                        <span class="bg-[#34d399] w-full h-full"></span>
                    </button>

                </div>
            </template>
        </Card>
    </Modal>
    <Modal :show="showCreateUserModal" @close="closeCreateUserModal" :maxWidth="'4xl'">
        <Processing :show="formCreateUser.processing" />
        <Card>
            <template #title>
                <div class="flex justify-between items-center">
                    <h1>Criar usuário</h1>
                    <button @click="closeCreateUserModal">
                        <i class="pi pi-times text-2xl hover:text-red-500 hover:scale-150"></i>
                    </button>
                </div>
            </template>
            <template #content>
                <form @submit.prevent="createUser">
                    <div class="grid md:grid-cols-2 gap-x-4 gap-y-8">
                        <div>
                            <span class="p-float-label w-full">
                                <InputText id="name" v-model="formCreateUser.name" class="w-full"
                                    @change="formCreateUser.validate('name')" />
                                <label for="name">Nome</label>
                            </span>
                            <span v-if="formCreateUser.invalid('name')" class="text-red-500">
                                {{ formCreateUser.errors.name }}
                            </span>
                        </div>
                        <div>
                            <span class="p-float-label w-full">
                                <InputText id="email" v-model="formCreateUser.email" class="w-full"
                                    @change="formCreateUser.validate('email')" />
                                <label for="email">E-mail</label>
                            </span>
                            <span v-if="formCreateUser.invalid('email')" class="text-red-500">
                                {{ formCreateUser.errors.email }}
                            </span>
                        </div>
                        <div class="">
                            <Calendar v-model="formCreateUser.birthdate" dateFormat="dd/mm/yy" showIcon class="w-full"
                                placeholder="Data de nascimento" :manualInput="false"
                                @change="formCreateUser.validate('birthdate')" />
                            <span v-if="formCreateUser.invalid('birthdate')" class="text-red-500">
                                {{ formCreateUser.errors.birthdate }}
                            </span>
                        </div>
                        <div>
                            <span class="p-float-label w-full">
                                <InputMask id="cpf" v-model="formCreateUser.cpf" class="w-full"
                                    @change="formCreateUser.validate('cpf')" mask="999.999.999-99" />
                                <label for="cpf">CPF</label>
                            </span>
                            <span v-if="formCreateUser.invalid('cpf')" class="text-red-500">
                                {{ formCreateUser.errors.cpf }}
                            </span>
                        </div>
                        <div>
                            <span class="p-float-label w-full">
                                <InputMask id="phone_number" v-model="formCreateUser.phone_number" class="w-full"
                                    @change="formCreateUser.validate('phone_number')" mask="(99) 9 9999-9999" />
                                <label for="phone_number">Número</label>
                            </span>
                            <span v-if="formCreateUser.invalid('phone_number')" class="text-red-500">
                                {{ formCreateUser.errors.phone_number }}
                            </span>
                        </div>
                        <span class="p-float-label">
                            <Dropdown id="role" v-model="formCreateUser.role" :options="roles" class="w-full md:w-14rem"
                                @change="formCreateUser.validate('role')" />
                            <label for="role">Cargo</label>
                            <span v-if="formCreateUser.invalid('role')" class="text-red-500">
                                {{ formCreateUser.errors.role }}
                            </span>
                        </span>
                        <div class="md:col-span-2 grid md:grid-cols-3 gap-2 gap-y-8">

                            <span class="p-float-label">
                                <Dropdown id="city" v-model="formCreateUser.city" :options="cities" class="w-full" />
                                <label for="city">Cidade</label>
                            </span>

                            <span class="p-float-label">
                                <Dropdown id="status" v-model="formCreateUser.status" :options="statuses"
                                    class="w-full md:w-14rem" @change="formCreateUser.validate('status')" />
                                <label for="status">Status</label>
                                <span v-if="formCreateUser.invalid('status')" class="text-red-500">
                                    {{ formCreateUser.errors.status }}
                                </span>
                            </span>
                            <span class="p-float-label">
                                <Dropdown id="gender" v-model="formCreateUser.gender" :options="genders"
                                    class="w-full md:w-14rem" @change="formCreateUser.validate('gender')" />
                                <label for="gender">Gênero</label>
                                <span v-if="formCreateUser.invalid('gender')" class="text-red-500">
                                    {{ formCreateUser.errors.gender }}
                                </span>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span>Verificar usuário</span>
                            <InputSwitch v-model="formCreateUser.email_verified_at" />
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-8">
                        <button type="button" @click="closeCreateUserModal"
                            class="p-4 border border-red-500 rounded-2xl hover:bg-red-500 w-28">Cancelar</button>
                        <button type="submit" :class="{ 'opacity-25': formCreateUser.processing }"
                            :disabled="formCreateUser.processing"
                            class="p-4 border border-green-500 rounded-2xl hover:bg-green-500 w-28">Salvar</button>
                    </div>
                </form>
            </template>
        </Card>
    </Modal>
    <Modal :show="showUpdateUserModal" @close="closeUpdateUserModal" :maxWidth="'4xl'">
        <Processing :show="formUpdateUser.processing" />
        <Card>
            <template #title>
                <div class="flex justify-between items-center">
                    <h1>Editar usuário {{ user.name }}</h1>
                    <button @click="closeUpdateUserModal">
                        <i class="pi pi-times text-2xl hover:text-red-500 hover:scale-150"></i>
                    </button>
                </div>
            </template>
            <template #content>
                <form @submit.prevent="updateUser">
                    <div class="grid md:grid-cols-2 gap-x-4 gap-y-8">
                        <div>
                            <span class="p-float-label w-full">
                                <InputText id="name" v-model="formUpdateUser.name" class="w-full"
                                    @change="formUpdateUser.validate('name')" />
                                <label for="name">Nome</label>
                            </span>
                            <span v-if="formUpdateUser.invalid('name')" class="text-red-500">
                                {{ formUpdateUser.errors.name }}
                            </span>
                        </div>
                        <div>
                            <span class="p-float-label w-full">
                                <InputText id="email" v-model="formUpdateUser.email" class="w-full"
                                    @change="formUpdateUser.validate('email')" />
                                <label for="email">E-mail</label>
                            </span>
                            <span v-if="formUpdateUser.invalid('email')" class="text-red-500">
                                {{ formUpdateUser.errors.email }}
                            </span>
                        </div>
                        <div class="">
                            <Calendar v-model="formUpdateUser.birthdate" dateFormat="dd/mm/yy" showIcon class="w-full"
                                placeholder="Data de nascimento" :manualInput="false"
                                @change="formUpdateUser.validate('birthdate')" />
                            <span v-if="formUpdateUser.invalid('birthdate')" class="text-red-500">
                                {{ formUpdateUser.errors.birthdate }}
                            </span>
                        </div>
                        <div>
                            <span class="p-float-label w-full">
                                <InputMask id="cpf" v-model="formUpdateUser.cpf" class="w-full"
                                    @change="formUpdateUser.validate('cpf')" mask="999.999.999-99" />
                                <label for="cpf">CPF</label>
                            </span>
                            <span v-if="formUpdateUser.invalid('cpf')" class="text-red-500">
                                {{ formUpdateUser.errors.cpf }}
                            </span>
                        </div>
                        <div>
                            <span class="p-float-label w-full">
                                <InputMask id="phone_number" v-model="formUpdateUser.phone_number" class="w-full"
                                    @change="formUpdateUser.validate('phone_number')" mask="(99) 9 9999-9999" />
                                <label for="phone_number">Número</label>
                            </span>
                            <span v-if="formUpdateUser.invalid('phone_number')" class="text-red-500">
                                {{ formUpdateUser.errors.phone_number }}
                            </span>
                        </div>
                        <span class="p-float-label">
                            <Dropdown id="role" v-model="formUpdateUser.role" :options="roles" class="w-full md:w-14rem"
                                @change="formUpdateUser.validate('role')" />
                            <label for="role">Cargo</label>
                            <span v-if="formUpdateUser.invalid('role')" class="text-red-500">
                                {{ formUpdateUser.errors.role }}
                            </span>
                        </span>
                        <div class="md:col-span-2 grid md:grid-cols-3 gap-2 gap-y-8">
                            <span class="p-float-label">
                                <Dropdown id="city" v-model="formUpdateUser.city" :options="cities" class="w-full" />
                                <label for="city">Cidade</label>
                            </span>

                            <span class="p-float-label">
                                <Dropdown id="status" v-model="formUpdateUser.status" :options="statuses"
                                    class="w-full md:w-14rem" @change="formUpdateUser.validate('status')" />
                                <label for="status">Status</label>
                                <span v-if="formUpdateUser.invalid('status')" class="text-red-500">
                                    {{ formUpdateUser.errors.status }}
                                </span>
                            </span>
                            <span class="p-float-label">
                                <Dropdown id="gender" v-model="formUpdateUser.gender" :options="genders"
                                    class="w-full md:w-14rem" @change="formUpdateUser.validate('gender')" />
                                <label for="gender">Gênero</label>
                                <span v-if="formUpdateUser.invalid('gender')" class="text-red-500">
                                    {{ formUpdateUser.errors.gender }}
                                </span>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span>Verificar usuário {{ formUpdateUser.email_verified_at }}</span>
                            <InputSwitch v-model="formUpdateUser.email_verified_at" />
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-8">
                        <button type="button" @click="closeUpdateUserModal"
                            class="p-4 border border-red-500 rounded-2xl hover:bg-red-500 w-28">Cancelar</button>
                        <button type="submit" :class="{ 'opacity-25': formUpdateUser.processing }"
                            :disabled="formUpdateUser.processing"
                            class="p-4 border border-green-500 rounded-2xl hover:bg-green-500 w-28">Salvar</button>
                    </div>
                </form>
            </template>

        </Card>
    </Modal>
    <ConfirmationModal :show="showDeleteUserConfirmModal" @close="closeDeleteUserConfirmModal">
        <template #title>
            EXCLUIR USUÁRIO
        </template>
        <template #content>
            Tem certeza que deseja excluir o usuário <span class="font-bold"> {{ user.name }}</span>?
        </template>
        <template #footer>
            <div class="flex justify-between w-full">
                <button type="button" @click.native="closeDeleteUserConfirmModal"
                    class="p-4 border border-red-500 rounded-2xl hover:bg-red-500 w-28 hover:text-[var(--primary-color-text)]">
                    Cancelar
                </button>
                <form @submit.prevent="deleteUser(user.id)">
                    <button
                        class="p-4 border border-red-500 rounded-2xl hover:bg-red-500 w-28 hover:text-[var(--primary-color-text)]"
                        type="submit">
                        Deletar
                    </button>
                </form>
            </div>
        </template>
    </ConfirmationModal>
    <div class="sm:ml-64 p-6 lg:p-8">

        <div class="flex justify-center items-center">
            <DataTable v-model:filters="filters" :value="users" paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]"
                showGridlines dataKey="id" removableSort filterDisplay="menu" :globalFilterFields="['name']"
                class="max-w-full" scrollable scrollHeight="70vh">
                <template #header>
                    <div class="flex justify-between">
                        <Button type="button" icon="pi pi-filter-slash" label="Clear" outlined @click="clearFilter()" />
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters['global'].value" placeholder="Pesquisa por palavra-chave" />
                        </span>
                    </div>
                </template>
                <template #empty> Nenhum usuário encontrado </template>
                <Column field="id" header="ID" sortable></Column>
                <Column field="email" header="Email" style="min-width: 12rem" sortable>
                    <template #body="{ data }">
                        {{ data.email }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" class="p-column-filter"
                            placeholder="Procure por email" />
                    </template>
                </Column>
                <Column field="name" header="Nome" style="min-width: 12rem" sortable>
                    <template #body="{ data }">
                        {{ data.name }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" class="p-column-filter"
                            placeholder="Procure por nome" />
                    </template>
                </Column>
                <Column field="birthdate" header="Nascimento" sortable filterField="birthdate" dataType="date"
                    style="min-width: 10rem">
                    <template #body="{ data }">
                        {{ formatDate(data.birthdate) }}
                    </template>
                    <template #filter="{ filterModel }">
                        <Calendar v-model="filterModel.value" dateFormat="dd/mm/yy" placeholder="dd/mm/yyyy"
                            :manualInput="false" />
                    </template>
                </Column>
                <Column field="cpf" header="CPF" style="min-width: 12rem" sortable>
                    <template #body="{ data }">
                        {{ formatCpf(data.cpf) }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" class="p-column-filter"
                            placeholder="Procure por CPF" />
                    </template>
                </Column>
                <Column header="Status" field="status" sortable :filterMenuStyle="{ width: '14rem' }"
                    style="min-width: 12rem">
                    <template #body="{ data }">
                        <Tag :value="data.status" :severity="getSeverityStatus(data.status)" />
                    </template>
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="statuses" placeholder="Selecione um"
                            class="p-column-filter" showClear>
                            <template #option="slotProps">
                                <Tag :value="slotProps.option" :severity="getSeverityStatus(slotProps.option)" />
                            </template>
                        </Dropdown>
                    </template>
                </Column>
                <Column header="Cargo" field="role" sortable :filterMenuStyle="{ width: '14rem' }" style="min-width: 12rem">
                    <template #body="{ data }">
                        <Tag :value="data.role" :severity="getSeverityRole(data.role)" />
                    </template>
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="roles" placeholder="Selecione um"
                            class="p-column-filter" showClear>
                            <template #option="slotProps">
                                <Tag :value="slotProps.option" :severity="getSeverityRole(slotProps.option)" />
                            </template>
                        </Dropdown>
                    </template>
                </Column>
                <Column header="Gênero" field="gender" sortable :filterMenuStyle="{ width: '14rem' }"
                    style="min-width: 12rem">
                    <template #body="{ data }">
                        <Tag :value="data.gender" :severity="getSeverityGender(data.gender)" />
                    </template>
                    <template #filter="{ filterModel }">
                        <Dropdown v-model="filterModel.value" :options="genders" placeholder="Selecione um"
                            class="p-column-filter" showClear>
                            <template #option="slotProps">
                                <Tag :value="slotProps.option" :severity="getSeverityGender(slotProps.option)" />
                            </template>
                        </Dropdown>
                    </template>
                </Column>
                <Column field="verified" sortable header="Verificado" dataType="boolean" bodyClass="text-center"
                    style="min-width: 8rem">
                    <template #body="{ data }">
                        <i class="pi"
                            :class="{ 'pi-check-circle text-green-500 ': data.verified, 'pi-times-circle text-red-500': !data.verified }"></i>
                    </template>
                    <template #filter="{ filterModel }">
                        <div class="px-8">
                            <label for="verified-filter" class="font-bold"> Verificado </label>
                            <TriStateCheckbox v-model="filterModel.value" inputId="verified-filter" class="ml-2" />
                        </div>
                    </template>
                </Column>
                <Column field="city" header="Cidade" style="min-width: 12rem" sortable>
                    <template #body="{ data }">
                        {{ data.city }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" class="p-column-filter"
                            placeholder="Procure por cidade" />
                    </template>
                </Column>
                <Column field="phone_number" header="Telefone" style="min-width: 12rem" sortable>
                    <template #body="{ data }">
                        {{ formatPhoneNumber(data.phone_number) }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText v-model="filterModel.value" type="text" class="p-column-filter"
                            placeholder="Procure por telefone" />
                    </template>
                </Column>

                <Column header="Ações" headerStyle="width: 5rem; text-align: center"
                    bodyStyle="text-align: center; overflow: visible">
                    <template #body="{ data }">
                        <div class="flex items-center justify-between gap-2">
                            <button type="button" @click="openUpdateUserModal(data)">
                                <PencilSquare />
                            </button>
                            <button type="button" @click="openDeleteUserConfirmModal(data)">
                                <Trash />
                            </button>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}

.neuphorism-btn {
    border-radius: 10px;
    background: #ffffff;
    box-shadow: 20px 20px 60px #d9d9d9,
        -20px -20px 60px #ffffff;
}

.button-theme {
    height: 50px;
    width: 120px;
    border-radius: 10px;
    background-color: var(--surface-50);
    justify-content: center;
    align-items: center;
    font-family: 'Damion', cursive;
    border: none;
    font-size: 16px;
    color: var(--text-color);
    transition: 500ms;
}

.button-theme:hover {
    scale: 125%;
    color: var(--text-color);
    transition: 500ms;
    border: 1px var(--primary-color) solid;
    transform: translateY(-10px);
}
</style>
<!-- <div v-if="canLogin" class="sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10">
    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
    Dashboard</Link>

    <template v-else>
        <Link :href="route('login')"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
        Log in</Link>

        <Link v-if="canRegister" :href="route('register')"
            class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
        Register</Link>
    </template>
</div> -->
