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
                <form>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" v-model="formData.name" name="name" class="form-control input_user" placeholder="Nome">
                    </div>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" v-model="formData.email" name="email" class="form-control input_user" placeholder="E-mail">
                    </div>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" v-model="formData.password" name="password" class="form-control input_pass" placeholder="Senha">
                    </div>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" v-model="formData.password_confirmation" name="password_confirmation" class="form-control input_pass" placeholder="Confirme a Senha">
                    </div>
                    <div class="d-flex justify-content-center login_container">
                        <button type="button" name="button" class="btn login_btn" 
                            :disabled="loading"
                            @click.prevent="registerClient">
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
            }
        }
    },
    methods: {
        ...mapActions([
                'register'
        ]),

        registerClient() {
            this.loading = true

            this.register(this.formData)
                .then((response) => {
                    console.log(response)
                })
                .catch(response => alert('Falha ao Registrar'))//this.$vToastify.error('Falha ao Registrar', 'Erro'))
                .finally(() => this.loading = false)
        }
    }
}
</script>
