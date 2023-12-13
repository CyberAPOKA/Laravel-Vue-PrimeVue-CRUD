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
            <Dropdown id="city" v-model="formUpdateUser.country" :options="countries" class="w-full" />
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
        <span>Verificar usuário</span>
        <InputSwitch v-model="formUpdateUser.email_verified_at" />
    </div>
</div>