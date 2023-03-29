<template>
    <div>
        <p v-if="Authenticated"> Already registered</p>
        <p v-if="!Authenticated" >Tap to register</p>


        <form @submit.prevent="submitForm" class="flex flex-col w-1/3 space-y-3">
            <span class="text-xs text-red-500 pl-2" v-for="error in v$.name.$errors" :key="error.$uid">{{ error.$message }}</span>
            <input type="text" v-model="formData.name">
            <span class="text-xs text-red-500 pl-2" v-for="error in v$.email.$errors" :key="error.$uid">{{ error.$message }}</span>
            <input type="email" v-model="formData.email">
            <span class="text-xs text-red-500 pl-2" v-for="error in v$.password.$errors" :key="error.$uid">{{ error.$message }}</span>
            <input type="password" v-model="formData.password">
            <input type="submit" value="submit" class="cursor-pointer">
        </form>
    </div>
</template>

<script setup>
import { reactive, computed } from 'vue';
import { useUserStore } from '@/stores/User';
import useVuelidate from '@vuelidate/core';
import { required,  minLength, email } from '@vuelidate/validators'

const { Authenticated } =  useUserStore();

const formData = reactive({
    name: '',
    email: '',
    password: ''
});
const rules = computed( () => {
    return {
        name: { required },
        email: { email, required },
        password: { required, minLength: minLength(8) }
    };
});
const v$ = useVuelidate(rules, formData);
const submitForm = async () => {
    const result = await v$.value.$validate();
    if(result) 
        alert('success');
}

</script>