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
                <form @submit.prevent="registerClient">
                    <div class="text-danger" v-if="errors.name != ''">
                        {{ errors.name[0] || '' }}
                    </div>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" v-model="formData.name" name="name" placeholder="Nome"
                            :class="['form-control', 'input_user', {'is-invalid' : errors.name != ''}]">
                    </div>
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
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" v-model="formData.password_confirmation" name="password_confirmation" placeholder="Confirme a Senha"
                            :class="['form-control', 'input_user', {'is-invalid' : errors.password != ''}]">
                    </div>
                    <div class="d-flex justify-content-center login_container">
                        <button type="submit" name="button" class="btn login_btn" 
                            :disabled="loading">
                                <span v-if="loading">Cadastrando...</span>
                                <span v-else>Cadastrar</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                    Já tem conta? 
                    <router-link :to="{name: 'login'}" >Entrar</router-link> 
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    data() {
        return {
            loading: false,
            formData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: {
                name: '',
                email: '',
                password: ''
            }
        }
    },
    methods: {
        ...mapActions([
                'register'
        ]),

        registerClient() {
            this.loading = true
            this.resetError()

            this.register(this.formData)
                .then((response) => {
                    alert('Cadastro realizado com sucesso!')
                    this.$router.push({name: 'login'})
                })
                .catch(error =>  {
                    const errorResp = error.response 
                    if(errorResp.status === 422) {
                        this.errors = Object.assign(this.errors, errorResp.data.errors)
                        alert('Dados inválidos')
                        return;
                    }
                    alert('Falha ao Registrar')//this.$vToastify.error('Falha ao Registrar', 'Erro'))
                })
                .finally(() => this.loading = false)
        },

        resetError () {
            this.errors = {
                name: '',
                email: '',
                password: ''
            }
        }
    }
}
</script>
