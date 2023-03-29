import { defineStore } from "pinia";
import { ref } from "vue"

export const useUserStore = defineStore
( "User", () => {
    const Authenticated = ref(false)
    return {Authenticated};
});