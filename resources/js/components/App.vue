<template>
    <div class="row">
        <div class="col-3">
            <div class="lista-items-menu">
                <router-link class="item-menu" to="/clientes">Clientes</router-link>
                <router-link v-show="$gate.isAdmin()" class="item-menu" to="/produtos">Produtos</router-link>
                <router-link class="item-menu" to="/vendas">Vendas</router-link>
            </div>
        </div>
        <div class="col-9">
            <main>
                <router-view></router-view>   
                <Loading />
            </main>
        </div>
    </div>
</template>
<script>
    import Loading from './elements/Loading.vue';
    export default {
        components:{
            Loading
        },
        props: ['baseUrl'],
        mounted(){
        }
    }
</script>
<style>
    *{
        overflow-x: hidden;
    }

    html, body{
        overflow-x: hidden;        
    }

    h1,h2,h3,h4,h5{
        overflow: hidden;
    }
    .lista-items-menu{
        background-color: #444444;
        height: 100%;
        width: 100%;
    }
    .lista-items-menu .item-menu{
        width: 100%;
        float: left;
        color: #fff;
        font-size: 15px;
        padding: 6px 20px;
    }
    .lista-items-menu .item-menu:hover{
        text-decoration: none;
        color:#ffffff;
    }
</style>
