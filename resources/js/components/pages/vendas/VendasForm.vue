<template>
    <div>
        <div class="modal fade" id="addNovaVenda" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Nova Venda</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="data_pedido">Data e hora da Venda</label>
                                <input v-mask="'##/##/#### ##:##:##'"  v-model="pedido.data_pedido" 
                                    type="text" class="form-control" 
                                    placeholder="Informe a data da venda" /> 
                            </div>
                            <div class="form-group col-lg-8">
                                <label for="cliente">Cliente:</label>
                                <select v-model="pedido.cliente_id" name="" class="form-control" @change="checkCliente()">
                                    <option value="" selected>Selecione o cliente</option>
                                    <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">{{ cliente.cpf_cnpj+' - '+cliente.nome }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="produto">Produtos:</label>
                                <select v-model="produto_selecionado" name="" class="form-control" @change="preencheFormProdItem(this.value)">
                                    <option value="" selected>Selecione o produto</option>
                                    <option v-for="produto in produtos" :key="produto.id" :value="produto">{{ produto.referencia + ' - ' + produto.descricao }}</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="preco_unit">Preço Unit.:</label>
                                <money v-model="produto_selecionado.preco_venda" class="form-control" placeholder="Informe o preço unitário"></money>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="quantidade">Qtd.</label>
                                <input v-model="produto_selecionado.quantidade"  type="text" class="form-control" placeholder="Informe a quantidade" />
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="">&nbsp;&nbsp;</label>
                                <button type="button" 
                                            class="btn btn-info btn-block" 
                                            v-show="produto_selecionado.id > 0"
                                            @click="incluirProduto()">
                                    <span><i class="fa fa-shopping-cart" aria-hidden="true"></i> Incluir Produto</span>    
                                </button>
                            </div>
                        </div>

                        <hr />
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="95px" class="text-center">Referencia</th>
                                    <th>Produto</th>
                                    <th width="150px" class="text-center">Preço Unit.</th>
                                    <th width="50px" class="text-center">Qtd.</th>
                                    <th width="95px">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item_carrinho, index) in pedido.items" :key="item_carrinho.produto_id">
                                    <td class="text-center">{{ item_carrinho.referencia }}</td>
                                    <td>{{ item_carrinho.descricao }}</td>
                                    <td class="text-center">R$ {{ item_carrinho.preco_unit }}</td>
                                    <td class="text-center">{{ item_carrinho.quantidade }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-block" @click="removerProdutoCarrinho(index)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-show="pedido.items.length > 0">
                                    <td class="text-right" colspan="2"><strong>Total:</strong></td>
                                    <td colspan="3"><strong>R$ {{ formatarValor(this.valor_total) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <hr />
                        <div class="col-lg-12">
                            <button v-show="habilitaFinalizacaoCompra" 
                                    type="button" 
                                    class="btn btn-info pull-right"
                                    @click="finalizarVenda()">
                                <span><i class="fa fa-check" aria-hidden="true"></i> Finalizar Venda</span>    
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
export default {
    components:{
        Datepicker
    },
    data(){
        return {
            data_hoje: new Date(),
            valor_total : 0.00,
            produtos:[],
            clientes:[],
            produto_selecionado:{ id : 0 , preco_venda : 0.00 , quantidade : null},
            pedido : {
                data_pedido : '',
                venda_realizada_em : '',
                cliente_id : 0,
                items : []
            }
        }
    },
    mounted(){
        this.getClientes();
        this.getProdutos();
    },
    computed:{
        habilitaFinalizacaoCompra(){
            if(this.pedido.cliente_id > 0 && 
               this.pedido.items.length > 0 && 
               this.pedido.data_pedido.trim() != ''){
                   return true;
            }else{
                return false;
            }
        },
    },
    methods:{
        formatarValor(valor) {
            let val = (valor/1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        limpaForm(){
            this.pedido.data_pedido = '';
            this.pedido.venda_realizada_em = '';
            this.pedido.cliente_id = 0;
            this.pedido.items      = [];
            this.produto_selecionado = { id : 0 };
        },
        calculaValorTotal(){
            this.valor_total = 0;
            for(var i in this.pedido.items){
                let itemAux = this.pedido.items[i];
                this.valor_total += itemAux.preco_unit*itemAux.quantidade;
            }
        },
        checkCliente(){
            if(!this.pedido.cliente_id){
                this.pedido.cliente_id = 0;
            }
        },
        removerProdutoCarrinho(pos){
            this.pedido.items.splice(pos, 1);
            this.calculaValorTotal();
        },
        incluirProduto(){

            let pos = -1;
            for(var k in this.pedido.items){
                let itemAux = this.pedido.items[k];
                if(itemAux.produto_id == this.produto_selecionado.id){
                    pos = k;
                }
            }

            if(pos >= 0){
                this.pedido.items[pos].quantidade += parseInt(this.produto_selecionado.quantidade);
            }else{
                let itemNovo = {
                    referencia : this.produto_selecionado.referencia,
                    descricao : this.produto_selecionado.descricao,
                    preco_unit : this.produto_selecionado.preco_venda,
                    quantidade : parseInt(this.produto_selecionado.quantidade),
                    produto_id : this.produto_selecionado.id
                };
                this.pedido.items.push(itemNovo);
            }
            this.calculaValorTotal();
        },
        preencheFormProdItem(){
            if(!this.produto_selecionado){
                this.produto_selecionado = { };
                this.produto_selecionado['id'] = 0; 
                this.produto_selecionado['preco_venda'] = null; 
                this.produto_selecionado['quantidade']  = null;
            }else{
                this.produto_selecionado['quantidade'] = 1;
            }
        },
        getClientes(){
            $("#loading").fadeIn('fast');
            axios.get(window.BaseUrl+'/../api/clientes')
                .then(response => { 
                    this.clientes = response.data;
                    $("#loading").fadeOut('fast'); 
                });
        },
        getProdutos(){
            $("#loading").fadeIn('fast');
            axios.get(window.BaseUrl+'/../api/produtos')
                .then(response => { 
                    this.produtos = response.data; 
                    $("#loading").fadeOut('fast');
                });
        },
        finalizarVenda(){
            swal({
                title: 'Deseja finalizar a venda?',
                text: "Após finalizada a venda não poderá ser alterada, deseja mesmo finaliza-la?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#015C7B',
                cancelButtonColor: '#B00020',
                confirmButtonText: 'Sim, finalizar agora!',
                cancelButtonText: 'Espera!'
            }).then((result) => {
                if(result.value){       
                    $("#loading").fadeIn('fast');
                    axios.post(window.BaseUrl+'/../api/pedidos', this.pedido).then(response => {
                        toast({
                            type: 'success',
                            title: 'Venda realizada com sucesso.'
                        });  
                        $("#loading").fadeOut('fast');
                        this.valor_total = 0.00;
                        this.limpaForm();
                    }).catch(error => {
                        toast({
                            type: 'error',
                            title: 'Erro ao realizar a venda.'
                        });  
                        $("#loading").fadeOut('fast');
                    });
                }
            });
        }
    }
}
</script>

<style>

</style>