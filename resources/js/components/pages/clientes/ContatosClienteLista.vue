<template>
    <div>
        <div class="modal fade" id="listaTelefones" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Telefones do Cliente: {{ this.cliente.nome }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="divErrors2" class="alert alert-danger">
                        </div>
                        <form>
                            <div class="row">
                                <div class="form-group col-lg-2">
                                    <label for="tipo">Tipo:</label>
                                    <select v-model="contato_cliente.tipo" name="tipo" class="form-control">
                                        <option value="">Selecione o tipo</option>
                                        <option value="whatsapp">Whatsapp</option>
                                        <option value="telefone">Telefone</option>
                                        <option value="email">E-mail</option>
                                    </select>    
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="contato">Contato:</label>
                                    <input v-model="contato_cliente.contato" type="text" name="contato" class="form-control" placeholder="Informe o contato do cliente" />
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="descricao">Descrição:</label>
                                    <input v-model="contato_cliente.descricao" type="text" name="descricao" class="form-control" placeholder="Informe uma descrição para o contato" />
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="">&nbsp;</label>
                                    <button type="button" class="btn btn-info btn-block" @click="addContatoCliente()">
                                        <span><i class="fa fa-floppy-o" aria-hidden="true"></i> Cadastrar</span>
                                    </button>
                                </div>
                            </div>
                            <input v-model="contato_cliente.cliente_id" type="hidden" name="cliente_id" />
                        </form>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;" @click="orderedContatos($event, 0)">Descrição</a>
                                    </th>
                                    <th class="text-center">
                                        <a href="javascript:;" @click="orderedContatos($event, 1)">Contato</a>
                                    </th>
                                    <th class="text-center">
                                        <a href="javascript:;" @click="orderedContatos($event, 2)">Tipo</a>
                                    </th>
                                    <th width="95px">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contato in contatos" :key="contato.id">
                                    <td>{{ contato.descricao }}</td>
                                    <td class="text-center">{{ contato.contato }}</td>
                                    <td class="text-center">{{ contato.tipo }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-block" @click="removerContato(contato.id)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
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
        props: ['cliente'],
        data(){
            return {
                sortProperties : [
                    { propriedade : 'descricao', direcao : 'asc' },
                    { propriedade : 'contato', direcao : 'asc' },
                    { propriedade : 'tipo', direcao : 'asc' }
                ],
                aux : 0,
                contatos: [],
                contato_cliente : {
                    tipo : '',
                    contato : '',
                    descricao : '',
                    cliente_id : 0
                },
                errors : [] 
            }
        },
        computed:{
        
        },
        methods:{
            orderedContatos(ev, posPropriedade) {

                if(this.sortProperties[posPropriedade].direcao == 'asc'){
                    this.sortProperties[posPropriedade].direcao = 'desc';
                }else{
                    this.sortProperties[posPropriedade].direcao = 'asc';
                }
                let propriedade = this.sortProperties[posPropriedade];
                this.contatos = _.orderBy(this.contatos, propriedade.propriedade, propriedade.direcao)
            },
            preencheErros(erros){
                var arrKeys = Object.keys(erros);
                var qtdErrors = 0;
                arrKeys.forEach(element => {
                    var errosPorChave = erros[element];
                    errosPorChave.forEach(sErro => {
                        qtdErrors++;
                        this.errors.push({ id : qtdErrors, erro : sErro });
                        $("#divErrors2").append($("<span>").css({ "width" : "100%",
                                                                "float" : "left",
                                                                "position" : "relative"}).html(sErro));
                        $("#divErrors2").show();
                    });
                });
            },
            removerContato(id){
                let msgRemove = "Tem certeza que deseja deletar "+
                        "esse contato do cliente: "+this.cliente.nome+" definitivamente?";
                swal({
                    title: 'Você tem certeza?',
                    text: msgRemove,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#015C7B',
                    cancelButtonColor: '#B00020',
                    confirmButtonText: 'Sim, deletar agora!',
                    cancelButtonText: 'Agora não!'
                    }).then((result) => {
                        if(result.value){
                            $("#loading").fadeIn('fast');
                            axios.delete(window.BaseUrl+'/../api/contatos-cliente/'+id)
                                .then(response => {
                                    toast({
                                        type: 'success',
                                        title: 'Contato deletado com sucesso'
                                    });
                                    $("#loading").fadeOut('fast');
                                    this.getContatosCliente(this.cliente.id);
                                })
                                .catch(error => {
                                    toast({
                                        type: 'error',
                                        title: 'Erro ao deletar contato'
                                    });
                                    $("#loading").fadeOut('fast');
                            });                          
                        }
                });
            },
            getContatosCliente(cliente_id){
                $("#loading").fadeIn('fast');
                axios.get(window.BaseUrl+'/../api/contatos-cliente/contatos-por-cliente/'+cliente_id)
                    .then(response => { 
                        this.contatos = response.data;
                        $("#loading").fadeOut('fast');
                    });
            },
            addContatoCliente(){
                $("#divErrors2 span").remove();
                $("#divErrors2").hide();

                this.contato_cliente.cliente_id = this.cliente.id;
                $("#loading").fadeIn('fast');
                axios.post(window.BaseUrl+'/../api/contatos-cliente', this.contato_cliente)
                .then(response => {
                    toast({
                        type: 'success',
                        title: 'Contato cadastrado com sucesso.'
                    });  
                    $("#loading").fadeOut('fast');
                    this.getContatosCliente(this.cliente.id);
                }).catch(error => {
                    this.preencheErros(error.response.data.errors);
                    toast({
                        type: 'error',
                        title: 'Erro ao cadastrar contato.'
                    });                
                    $("#loading").fadeOut('fast');
                });
            }
        },
        mounted(){
            $("#divErrors2").hide();
        },
        updated(){
            if(this.aux != this.cliente.id){
                this.getContatosCliente(this.cliente.id);
                this.aux = this.cliente.id;    
            }
        }
    }
</script>

<style>

</style>
