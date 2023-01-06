<template>
    <div>
        <preloader-component/>
        <header-component/>

        <div class="container container-body">
            <router-view></router-view>
        </div>

        <footer-component/>
    </div>
</template>

<script>
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
</style>