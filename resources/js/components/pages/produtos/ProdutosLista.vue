<template>
    <div class="p-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-info" @click="modalNovoProduto()">
                            <span><i class="fa fa-plus" aria-hidden="true"></i> Novo Produto</span>
                        </button>                   
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-info btn-block" @click="getProdutos()">
                            <span><i class="fa fa-refresh" aria-hidden="true"></i> Recarregar</span>
                        </button>                        
                    </div>
                    <div class="col-lg-8 pull-right">
                        <input type="text" class="form-control" placeholder="Digite sua busca aqui" @input="filtro = $event.target.value" />
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="100px" class="text-center">
                                <a href="javascript:;" @click="orderedProdutos($event, 0)">Referencia</a>
                            </th>
                            <th>
                                <a href="javascript:;" @click="orderedProdutos($event, 1)">Descrição</a>
                            </th>
                            <th class="text-center">
                                <a href="javascript:;" @click="orderedProdutos($event, 2)">Marca</a>
                            </th>
                            <th width="95px" class="text-center">
                                <a href="javascript:;" @click="orderedProdutos($event, 3)">Preço</a>
                            </th>
                            <th width="95px" class="text-center">
                                <a href="javascript:;" @click="orderedProdutos($event, 4)">Estoque</a>
                            </th>
                            <th width="95px">Editar/Ver</th>
                            <th width="95px">Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="produto in filtroProdutos" :key="produto.id">
                            <td class="text-center">{{ produto.referencia }}</td>
                            <td>{{ produto.descricao }}</td>
                            <td class="text-center">{{ produto.marca }}</td>
                            <td class="text-center">{{ produto.preco_venda }}</td>
                            <td class="text-center">{{ produto.estoque }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-block" @click="abrirModalEdicao(produto)">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-block" @click="deletarProduto(produto.id)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <ProdutosForm :editmode="edit_invoker" :produto="produto_selecionado" />
    </div>
</template>

<script>
import ProdutosForm from './ProdutosForm'
export default {
    components:{
        ProdutosForm
    },
    data(){
        return{
            sortProperties : [
                { propriedade : 'referencia', direcao : 'asc' },
                { propriedade : 'descricao', direcao : 'asc' },
                { propriedade : 'marca', direcao : 'asc' },
                { propriedade : 'preco_venda', direcao : 'asc' },
                { propriedade : 'estoque', direcao : 'asc' }
            ],
            produtos: [],
            filtro: '',
            edit_invoker: false,
            produto_selecionado: {  }           
        }
    },
    computed: {
        filtroProdutos(){
            if(this.filtro){
                let exp = new RegExp(this.filtro.trim(), 'i');
                return this.produtos.filter(produto => exp.test(produto.referencia+'|'+produto.descricao+'|'+produto.marca+'|'+produto.preco_venda+'|'+produto.estoque));
            }else{
                return this.produtos;
            }
        }
    },
    methods:{
        orderedProdutos(ev, posPropriedade) {

            if(this.sortProperties[posPropriedade].direcao == 'asc'){
                this.sortProperties[posPropriedade].direcao = 'desc';
            }else{
                this.sortProperties[posPropriedade].direcao = 'asc';
            }
            let propriedade = this.sortProperties[posPropriedade];
            this.produtos = _.orderBy(this.produtos, propriedade.propriedade, propriedade.direcao)
        },
        getProdutos(){
            $("#loading").fadeIn('fast');
            axios.get(window.BaseUrl+'/../api/produtos')
                .then(response => {
                    this.produtos = response.data;
                    $("#loading").fadeOut('fast');
                });
        },
        modalNovoProduto(){
            this.edit_invoker = false;
            this.produto_selecionado = {                
                id : 0,
                referencia : '', 
                descricao : '', 
                marca : '', 
                preco_venda : '', 
                estoque : '', 
                unidade_venda : ''
            };
            $('#addNovoProduto').modal('show');
        },
        abrirModalEdicao(produto){
            this.edit_invoker = true;
            this.produto_selecionado = produto;
            $('#addNovoProduto').modal('show');
        },
        deletarProduto(id){
            swal({
                title: 'Você tem certeza?',
                text: "Deseja realmente remover esse produto?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#015C7B',
                cancelButtonColor: '#B00020',
                confirmButtonText: 'Sim, remover agora!',
                cancelButtonText: 'Agora não!'
            }).then((result) => {
                if(result.value){
                    $("#loading").fadeIn('fast');
                    axios.delete(window.BaseUrl+'/../api/produtos/'+id)
                        .then(response => {
                            toast({
                                type: 'success',
                                title: 'Produto deletado com sucesso.'
                            });
                            $("#loading").fadeOut('fast');
                            this.getProdutos();
                        })
                        .catch(error => {
                            toast({
                                type: 'error',
                                title: 'Erro ao deletar produto.'
                            });
                            $("#loading").fadeOut('fast');
                        });                          
                }
            });
        }
    },
    mounted(){
        this.getProdutos();
    },
    created(){

    }
}
</script>

<style>

</style>
