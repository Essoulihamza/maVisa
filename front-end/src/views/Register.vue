<template>
    <section>
        <form @submit.prevent="submitForm" class="w-1/3 mx-auto bg-teal-400 p-6 space-y-8 rounded">
        <div class="flex flex-col items-center">
            <h1 class="text-3xl font-bold">Register form</h1>
            <p>register and get your tracking token</p>
        </div>
        <div class="flex flex-col space-y-6">
            <div class="w-full flex space-x-3">
                <input v-model="formData.firstName" type="text" class="rounded w-full" placeholder="First name">
                <input v-model="formData.lastName" type="text" class="rounded w-full" placeholder="Last name">
            </div>
            <div class="w-full flex space-x-3">
                <input v-model="formData.birthdate" type="date" class="w-full rounded" >
                <input v-model="formData.familySituation" type="text" class="w-full rounded" placeholder="Family situation">
            </div>
            <div class="w-full flex flex-col items-center space-y-3">
                <input v-model="formData.nationality" type="text" class="w-full rounded" placeholder="Nationality">
                <input v-model="formData.address" type="text" class="w-full rounded" placeholder="Address">
            </div>
            <div class="w-full flex space-x-3">
                <input v-model="formData.arrivalDate" class="w-full rounded" type="date" >
                <input v-model="formData.departureDate" class="w-full rounded" type="date" >
            </div>
            <div class="w-full flex flex-col space-y-3">
                <input v-model="formData.visaType" type="text" class="w-full rounded" placeholder="Visa type">
                <input v-model="formData.documentType" type="text" class="w-full rounded" placeholder="Document type">
                <input v-model="formData.documentNumber" type="text" class="w-full rounded" placeholder="Document number">
            </div>
            <input type="submit" value="Submit" class="rounded px-3 py-1 bg-black text-white cursor-pointer">
        </div>

    </form>
    </section>
</template>

<script setup>
import { reactive, computed } from 'vue';
import { useUserStore } from '@/stores/User';


const User =  useUserStore();

const formData = reactive({
    firstName: '',
    lastName: '',
    birthdate: '',
    nationality: '',
    familySituation: '',
    address: '',
    visaType: '',
    arrivalDate: '',
    departureDate: '',
    documentType: '',
    documentNumber: ''
});

function submitForm() {
    let request =  User.register(formData)
    if(request) 
        this.$router({name: Tracking});
    else 
        alert('some thing went wrong!')
}


</script>