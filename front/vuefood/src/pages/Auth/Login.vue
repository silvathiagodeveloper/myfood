<template>
    <div class="d-flex justify-content-center h-100 my-5">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <router-link :to="{name: 'home'}">
                        <img src="@/assets/imgs/vue-food.png" class="brand_logo" alt="Logo">
                    </router-link>
                </div>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form @submit.prevent="auth">
                    <div class="text-danger" v-if="errors.email != ''">
                        {{ errors.email[0] || '' }}
                    </div>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" v-model="formData.email" name="email" placeholder="E-mail"
                            :class="['form-control', 'input_user', {'is-invalid' : errors.email != ''}]">
                    </div>
                    <div class="text-danger" v-if="errors.password != ''">
                        {{ errors.password[0] || '' }}
                    </div>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" v-model="formData.password" name="password" placeholder="Senha"
                            :class="['form-control', 'input_user', {'is-invalid' : errors.password != ''}]">
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" name="button" class="btn login_btn" 
                            :disabled="loading">
                                <span v-if="loading">Autenticando...</span>
                                <span v-else>Entrar</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                    Não tem uma conta? 
                    <router-link :to="{name: 'register'}">Cadastre-se!</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';

export default {

    computed: {
        deviceName() {
            return navigator.appCodeName + navigator.appName + navigator.platform + this.formData.email
        }
    },

    data() {
        return {
            loading: false,
            formData: {
                email: '',
                password: '',
            },
            errors: {
                email: '',
                password: ''
            }
        }
    },

    methods: {
        ...mapActions([
                'login'
        ]),

        auth() {
            this.loading = true
            this.resetError()

            const params = {
                device_name: this.deviceName,
                ...this.formData
            }

            this.login(params)
                .then((response) => {
                    toast.success('Login realizado com sucesso!');
                    this.$router.push({name: 'home'})
                })
                .catch(error =>  {
                    const errorResp = error.response 
                    if(errorResp.status === 422 || errorResp.status === 401) {
                        this.errors = Object.assign(this.errors, errorResp.data.errors)
                        toast.error('Dados inválidos!');
                        return;
                    }
                    toast.error('Falha ao Autenticar');
                })
                .finally(() => this.loading = false)
        },


        resetError () {
            this.errors = {
                email: '',
                password: ''
            }
        }
    }
}
</script>