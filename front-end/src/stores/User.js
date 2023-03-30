import { defineStore } from "pinia";
import { ref } from "vue"
import axios from "axios"

export const useUserStore = defineStore
( "User", () => {
    const Authenticated = ref(false);
    const User = ref({});
    async function register(data){
        try{
            let request = await axios('http://mavisa.com/User', data);
            User = request.data
            return 1
        }catch(error){
            console.log(error)
            return 0
        }
    }
    return {Authenticated, User, register};
});