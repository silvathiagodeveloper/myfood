<template>
    <div>
        <h1 class="my-4 title-tenant text-center">{{ tenant.name }}</h1>
        <div class="row">
            
            
            <div class="list-categories">
                <a href="#" v-for="(category, index) in categories.data" :key="index" @click.prevent="getFilterProducts(category.id)"
                :class="['list-categories__item', {'active': categorySelected == category.id}]">
                    <div class="icon">
                        <i class="fas fa-pizza-slice"></i>
                    </div>
                    <span> {{ category.name }} </span>
                </a>
            </div>

        </div>
        <!-- Cards Produtos -->
        <div class="row my-4">
            <div class="col-lg-4 col-md-6 mb-4" v-for="(product, index) in products.data" :key="index">
                <div class="card--flat h-100">
                    <a href="#">
                        <div class="card-image">
                            <img v-if="product.image" class="card-img-top" :src="product.image" alt=""/>
                            <img v-else class="card-img-top" src="@/assets/imgs/pizza.png" alt=""/>
                        </div>
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="#">{{ product.name }}</a>
                        </h4>
                        <h5>R$ {{ product.price }}</h5>
                        <p class="card-text">{{ product.description}}</p>
                    </div>
                    <div class="card-footer card-footer-custom">
                        <router-link :to="{name: 'cart'}">Adicionar no Carrinho <i class="fas fa-cart-plus"></i></router-link>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</template>
<script>
import { mapActions, mapState, mapMutations } from 'vuex';
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';

export default {
    props: ['company_token'],

    created() {
        if(this.tenant.name == "") {
            return this.$router.push({name: 'home'})
        }
        this.getCategories(this.tenant.id)
            .catch(response => { toast.error('Falha ao carregar categorias!') })
        this.getProducts(this.tenant.id)
            .catch(response => { toast.error('Falha ao carregar produtos!') })
    },

    computed: {
        ...mapState({
            tenant: state=> state.tenants.selectedTenant,
            categories: state => state.tenants.categories, 
            products: state => state.tenants.products
        })
    },

    data() {
        return {
            categorySelected: ''
        }
    },

    methods: {
        ...mapActions([
            'getCategories',
            'getProducts',
            'getProductsByCategory'
        ]),
        getFilterProducts(categoryId) {
            if(this.categorySelected == categoryId) {
                this.categorySelected = ''
                this.getProducts(this.tenant.id)
                    .catch(response => { toast.error('Falha ao carregar produtos!') })
            } else {
                this.categorySelected = categoryId
                this.getProductsByCategory({token_company: this.tenant.id, categoryId: categoryId})
                   .catch(response => { toast.error('Falha ao carregar produtos!') })
            }
        }
    }
}
</script>