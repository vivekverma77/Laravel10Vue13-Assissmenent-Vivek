<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Register</h1>
                        <hr/>
                        <form action="javascript:void(0)" @submit="handleSubmit" class="row" method="post">
                    
                            <div class="form-group col-12">
                                <label for="name" class="font-weight-bold" :class="{ 'is-invalid': errors.name && errors.name[0] }">Name</label>
                                <input type="text" name="name" v-model="user.name" id="name" placeholder="Enter name" class="form-control">
                                <div class="invalid-feedback" v-if="errors.name && errors.name[0]">
                                    {{ errors.name && errors.name[0] }}
                                </div>
                            </div>
                            <div class="form-group col-12 my-2">
                                <label for="email" class="font-weight-bold"  :class="{ 'is-invalid': errors.email && errors.email[0] }">Email</label>
                                <input type="text" name="email" v-model="user.email" id="email" placeholder="Enter Email" class="form-control">
                                <div class="invalid-feedback" v-if="errors.email && errors.email[0]">
                                    {{ errors.email && errors.email[0] }}
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="password" class="font-weight-bold" :class="{ 'is-invalid': errors.password && errors.password[0] }">Password</label>
                                <input type="password" name="password" v-model="user.password" id="password" placeholder="Enter Password" class="form-control">
                                <div class="invalid-feedback" v-if="errors.password && errors.password[0]">
                                    {{ errors.password && errors.password[0] }}
                                </div>
                            </div>
                            <div class="form-group col-12 my-2">
                                <label for="password_confirmation" class="font-weight-bold">Confirm Password</label>
                                <input type="password_confirmation" name="password_confirmation" v-model="user.password_confirmation" id="password_confirmation" placeholder="Enter Password" class="form-control">
                            </div>
                            <div class="col-12 mb-2">
                                <button type="submit" :disabled="processing" class="btn btn-primary btn-block">
                                    {{ processing ? "Please wait" : "Register" }}
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <label>Already have an account? <router-link :to="{name:'login'}">Login Now!</router-link></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { reactive } from "vue";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";

const router = useRouter()
const store = useAuthStore()
const { isLoggedIn, errors } = storeToRefs(store)
const { handleRegister } = store

const user = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const handleSubmit = async () => {
    await handleRegister(user)
    if (isLoggedIn.value) {
        router.push({ name: 'tasks' })
    }
}
</script>