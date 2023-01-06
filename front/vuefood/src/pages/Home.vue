<template>
    <div class="row">

<div class="col-lg-12">

  <h1 class="my-4 title-tenant">Restaurantes</h1>

  <div class="row my-4">

    <div class="col-lg-4 col-md-4 col-6 mb-4" v-for="(tenant, index) in tenants.data" :key="index">
      <div class="restaurant-card">
        <a class="logo" href="vitrine-tenant.html">
          <img v-if="tenant.logo" 
            class="card-img-top" 
            :src="tenant.logo" 
            :alt="tenant.name">
          <img v-else 
            class="card-img-top" 
            src="@/assets/imgs/vue-food.png" 
            :alt="tenant.name">
        </a>
        <div class="restaurant-card-body">
          <h3>
            <router-link :to="{name: 'products'}">{{ tenant.name }}</router-link>
          </h3>
        </div>
      </div>
    </div>

  </div>
  <!-- /.row -->

</div>
<!-- /.col-lg-9 -->

</div>
<!-- /.row -->
</template>

<script>
import { mapActions, mapState } from 'vuex';
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';

export default {
  mounted() {
    this.getTenants()
        .catch(response => { toast.error('Falha ao carregar empresas!') })
  },

  computed: {
    // tenants () {
    //   return this.$store.state.tenants.items
    // }
    ...mapState({
      tenants: state => state.tenants.items
    })
  },

  methods: {
    ...mapActions([
      'getTenants'
    ])
  }
}
</script>