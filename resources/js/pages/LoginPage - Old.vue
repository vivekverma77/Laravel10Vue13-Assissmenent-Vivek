<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center mt-5">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Login</h1>
                        <hr/>
                        <form action="javascript:void(0)" class="row" method="post" @submit.prevent="handleSubmit">
                    
                            <div class="form-group col-12">
                                <label for="email" class="font-weight-bold" :class="{'is-invalid' : errors.email && errors.email[0] }">Email</label>
                                <input type="text" v-model="form.email" name="email" id="email" class="form-control">
                                <div class="invalid-feedback" v-if="errors.email && errors.email[0]">{{errors.email && errors.email[0]}}</div>

                            </div>
                            <div class="form-group col-12 my-2">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input type="password" :class="{'is-invalid' : errors.password && errors.password[0] }" v-model="form.password" name="password" id="password" class="form-control">
                                <div class="invalid-feedback" v-if="errors.password && errors.password[0]">{{errors.password && errors.password[0]}}</div>
                            </div>
                            <div class="col-12 mb-2">
                                <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block">
                                    {{ processing ? "Please wait" : "Login" }}
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <label>Don't have an account? <router-link :to="{name:'register'}">Register Now!</router-link></label>
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
const { handleLogin } = store

const form = reactive({
    email: '',
    password: '' 
})

const handleSubmit = async () => {
    await handleLogin(form)
    console.log(isLoggedIn.value);
    if (isLoggedIn.value) {
        router.push({ name: 'tasks' })
    }
}
</script>