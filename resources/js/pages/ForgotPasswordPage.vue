<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center mt-5">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Forgot Password</h1>
                        <hr/>
                        <div v-show="success" class="alert alert-success">We have e-mailed your password reset link!</div>
                        <form action="javascript:void(0)" class="row" method="post" @submit.prevent="handleSubmit">
                    
                            <div class="form-group col-12">
                                <label for="email" class="font-weight-bold" :class="{'is-invalid' : errors.email && errors.email[0] }">Email</label>
                                <input type="text" v-model="form.email" name="email" id="email" class="form-control">
                                <div class="invalid-feedback" v-if="errors.email && errors.email[0]">{{errors.email && errors.email[0]}}</div>

                            </div>
                            <div class="col-12 mb-4 mt-2 text-center">
                                <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block">
                                    {{ processing ? "Please wait" : "Submit" }}
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <label><router-link :to="{name:'login'}">Login Now!</router-link></label>
                            </div>
                            <div class="col-12 text-center mt-2">
                                <label><router-link :to="{name:'register'}">Register Now!</router-link></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { reactive, ref } from "vue";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";

const router = useRouter()
const store = useAuthStore()
const { errors } = storeToRefs(store)
const { handleForgotPassword } = store
const processing = ref(false)
const success = ref(false)

const form = reactive({
    email: '',
})

const handleSubmit = async () => {
    processing.value = true;
    await handleForgotPassword(form)
    processing.value = false;
    success.value = true;
    form.email.value = '';
   
}
</script>