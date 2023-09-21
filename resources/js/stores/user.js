import {ref,computed} from "vue";
import { defineStore } from "pinia";
import { allUsers } from "../http/user-api";

export const useUserStore = defineStore("userStore",()=>{
    const users = ref([]);

    const fetchAllUsers = async() => {
       const { data } = await allUsers();
       users.value = data.data;
    } 

    return {
        users,
        fetchAllUsers
    };
});