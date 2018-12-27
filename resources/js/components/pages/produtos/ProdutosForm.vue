<template>
    <div>
        <div class="modal fade" id="addNovoProduto" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title">Cadastro de Novo Produto</h5>
                        <h5 v-show="editmode" class="modal-title">Editando o produto: {{ produto.referencia + ' - ' + produto.descricao }} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="divErrors3" class="alert alert-danger"></div>
                        <form>
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <label for="referencia">Referencia</label>
                                    <input v-model="produto.referencia" type="text" class="form-control" name="referencia" placeholder="Digigi o cod. de referencia do produto" />
                                </div>
                                <div class="form-group col-lg-7">
                                    <label for="descricao">Descrição</label>
                                    <input v-model="produto.descricao" type="text" class="form-control" name="descricao" placeholder="O que é esse produto?" />
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="marca">Marca</label>
                                    <input v-model="produto.marca" type="text" class="form-control" name="marca" placeholder="Informe a marca" />
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="preco_venda">Preço de Venda</label>
                                    <money v-model="produto.preco_venda" class="form-control" placeholder="Informe o preço de venda"></money>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="estoque">Qtd. em Estoque</label>
                                    <input v-model="produto.estoque" type="text" class="form-control" name="estoque" placeholder="Informe a qtd. em estoque" />
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="unidade_venda">Unidade Venda</label>
                                    <input v-model="produto.unidade_venda" type="text" class="form-control" name="unidade_venda" placeholder="Qual a unidade de venda?" />
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="">&nbsp;</label>
                                    <button v-show="!editmode" type="button" class="btn btn-info btn-block" @click="addProduto()">
                                        <span><i class="fa fa-floppy-o" aria-hidden="true"></i> Cadastrar</span>
                                    </button>
                                    <button v-show="editmode" type="button" class="btn btn-info btn-block" @click="editarProduto()">
                                        <span><i class="fa fa-floppy-o" aria-hidden="true"></i> Editar</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
 

export default {
    props: ['editmode', 'produto'],
    data(){
        return {
            errors: []
        }
    },
    mounted(){
        $("#divErrors3").hide();
    },
    methods:{
        preencheErros(erros){
            var arrKeys = Object.keys(erros);
            var qtdErrors = 0;
            arrKeys.forEach(element => {
                var errosPorChave = erros[element];
                errosPorChave.forEach(sErro => {
                    qtdErrors++;
                    this.errors.push({ id : qtdErrors, erro : sErro });
                    $("#divErrors3").append($("<span>").css({ "width" : "100%",
                                                             "float" : "left",
                                                             "position" : "relative"}).html(sErro));
                    $("#divErrors3").show();
                });
            });
        },
        limpaForm(){
            this.produto.referencia = '';
            this.produto.descricao = '';
            this.produto.marca = '';
            this.produto.preco_venda = '';
            this.produto.estoque = '';
            this.produto.unidade_venda = '';
        },
        editarProduto(){
            $("#divErrors3 span").remove();
            $("#divErrors3").hide();
            $("#loading").fadeIn('fast');
            axios.put(window.BaseUrl+'/../api/produtos/'+this.produto.id, this.produto).then(response => {
                toast({
                    type: 'success',
                    title: 'Produto alterado com sucesso.'
                });
                $("#loading").fadeOut('fast');
            }).catch(error => {
                this.preencheErros(error.response.data.errors);
                toast({
                    type: 'error',
                    title: 'Erro ao alterar produto.'
                });                
                $("#loading").fadeOut('fast');
            });
        },
        addProduto(){
            $("#divErrors3 span").remove();
            $("#divErrors3").hide();
            $("#loading").fadeIn('fast');
            axios.post(window.BaseUrl+'/../api/produtos', this.produto).then(response => {
                toast({
                    type: 'success',
                    title: 'Produto cadastrado com sucesso.'
                });  
                $("#loading").fadeOut('fast');
                this.limpaForm();
            }).catch(error => {
                this.preencheErros(error.response.data.errors);
                toast({
                    type: 'error',
                    title: 'Erro ao cadastrar produto.'
                });                
                $("#loading").fadeOut('fast');
            });
        }
    }
}
</script>

<style>

</style>