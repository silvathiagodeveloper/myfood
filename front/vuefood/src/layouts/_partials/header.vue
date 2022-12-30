<template>
    <header>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-vuefood">
            <div class="container">
                <router-link :to="{name: 'home'}" class="navbar-brand">
                    <img src="@/assets/imgs/vue-food.png" alt="VueFood" class="logo">
                </router-link>
                <div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item nav-cart">
                            <router-link :to="{name: 'cart'}" class="nav-link">Carrinho
                                <i class="fas fa-shopping-cart"></i> (2)
                            </router-link>
                        </li>
                        <li class="nav-item nav-cart active">
                            <router-link :to="{name: 'login'}" class="nav-link">Entrar
                                <i class="fas fa-user"></i>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
    </header>
</template>