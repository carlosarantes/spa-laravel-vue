<template>
    <div class="col-lg-4">
        <div :class="classe" class="item-informativo verde">
            <h5>{{ titulo }}</h5>
            <h3>{{ numero }}</h3>
            <i class="fa" :class="icone" aria-hidden="true"></i>
            <p>{{ texto }}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: ['classe', 'titulo', 'numero', 'icone', 'texto']
}
</script>

<style scoped>
    .item-informativo{
        text-align: center;
        border: 1px #eeeeee solid;
        padding: 15px;
    }
    .item-informativo.verde{
        background-color: #0D8F4F;
    }
    .item-informativo.azul{
        background-color: #144888;
    }
    .item-informativo.vermelho{
        background-color: #BE2C2D;
    }
    .item-informativo h5{
        color: #ffffff;
        font-size: 15px;
        margin: 0;
    }
    .item-informativo h3{
        color: #ffffff;
        margin: 10px 0;
        font-size: 32px;
        font-weight: 800;
    }
    .item-informativo i{
        font-size: 45px;
        color: #ffffff;
        margin: 5px 0;
    }
    .item-informativo p{
        color: #ffffff;
        font-size: 12px;
        margin: 0;
    }
</style>