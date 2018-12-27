<template>
    <div class="modal fade" id="modalComprovante" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comprovante de Venda</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="comprovante">
                        <p>Cod. da Venda: 000{{ venda.id }}</p>
                        <h4>{{ venda.data_venda }}</h4>
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <h3 class="nome">{{ venda.nome_cliente }}</h3>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <p>Valor Total:</p>
                        <h3 class="valor_total">R$ {{ formatarValor(venda.valor_total) }}</h3>
                        <p>Items da compra:</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th class="text-center">Quantidade</th>
                                    <th class="text-center">Valor Unit.</th>
                                    <th class="text-center">Valor Total</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in items" :key="item.id">
                                    <td>{{ item.produto }}</td>
                                    <td class="text-center">{{ item.quantidade }}</td>
                                    <td class="text-center">R$ {{ formatarValor(item.preco_unit) }}</td>
                                    <td class="text-center">R$ {{ formatarValor(item.preco_unit*item.quantidade) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['venda'],
        data(){
            return{
                aux : 0,
                items: []
            }
        },
        mounted(){   
        },
        updated(){
            if(this.aux != this.venda.id){
                this.getItemsVenda(this.venda.id);
                this.aux = this.venda.id;    
            }
        },
        methods:{
            formatarValor(valor) {
                let val = (valor/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            getItemsVenda(venda_id){
                $("#loading").fadeIn();
                axios.get(window.BaseUrl+'/../api/items-pedido/items-por-pedido/'+venda_id)
                    .then(response => {
                        this.items = response.data;
                        $("#loading").fadeOut('fast');
                    });
            }
        }
    }
</script>

<style scoped>
    .comprovante{
        text-align: center
    }
    .comprovante i{
        font-size: 45px;
    }
    .comprovante i.fa-user{
        margin-top: 15px;
    }
    .comprovante i.fa-shopping-cart{
        margin-bottom: 15px;
    }
    .comprovante p{
        margin: 0;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: #666;
    }
    .comprovante h3.nome{
        text-align: center;
        font-weight: 800;
        font-size: 31px;
        margin: 15px 0;
    }
    .comprovante h3.valor_total{
        text-align: center;
        font-weight: 800;
        font-size: 27px;
        margin: 0 0 15px;
    }
    .comprovante h4{
        text-align: center;
        font-size: 20px;
        margin: 0;
    }
    .comprovante table{
        width: 90%;
        margin: 0 5%;
    }
    .comprovante table tr th{
        font-size: 13px;
        background-color: #e4e4e4;
        padding: 4px 7px;
        border-bottom: 1px #bbb solid;
    }
    .comprovante table tr td{
        font-size: 13px;
        padding: 4px 7px;
        border-bottom: 1px #ccc solid;
    }
</style>