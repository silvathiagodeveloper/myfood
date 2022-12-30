<template>
    <div class="container container-body">
        <router-view></router-view>
    </div>
</template>

<script>
    import 'bootstrap'
    import 'bootstrap/dist/css/bootstrap.min.css'
    import HeaderComponent from './_partials/header'
    import FooterComponent from './_partials/footer'

    export default {
        components: {
            HeaderComponent,
            FooterComponent
        }
    }
</script>

<style scoped>
    @import url('../assets/css/vuefood.css');
    @import url('../assets/css/reset.css');
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css');
</style>