<template>
    <div>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editmode" class="modal-title">Cadastro de Novo Cliente</h5>
                        <h5 v-show="editmode" class="modal-title">Editando o cliente {{ cliente.nome }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="divErrors" class="alert alert-danger">
                        </div>
                        <form>
                            <div class="row">
                                <div class="form-group col-lg-9">
                                    <label for="nome">Nome:</label>
                                    <input  type="text" name="nome" v-model="cliente.nome" placeholder="Digite o nome" class="form-control" />
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="cpf_cnpj">CPF/CNPJ:</label>
                                    <input  type="text" name="cpf_cnpj" v-model="cliente.cpf_cnpj" v-mask="'###.###.###-##'" placeholder="Digite o cpf" class="form-control" />
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="cep">CEP:</label>
                                    <input type="text" name="cep" v-model="cliente.cep" v-mask="'##.###-###'" placeholder="Digite o CEP" class="form-control" />
                                </div>
                                <div class="form-group col-lg-7">
                                    <label for="endereco">Endereço:</label>
                                    <input type="text" name="endereco" v-model="cliente.endereco" placeholder="Digite o endereço" class="form-control" />
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="num">Num:</label>
                                    <input type="text" name="num" v-model="cliente.num" placeholder="Digite o num" class="form-control" />
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="bairro">Bairro:</label>
                                    <input type="text" name="bairro" v-model="cliente.bairro" placeholder="Digite o bairro" class="form-control" />
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="cidade">Cidade:</label>
                                    <input type="text" name="cidade" v-model="cliente.cidade" placeholder="Digite a cidade" class="form-control" /> 
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="estado">Estado:</label>
                                    <select name="estado" v-model="cliente.estado" class="form-control">
                                        <option value="">Informe o estado</option>
                                        <option value="AC">Acre (AC)</option>
                                        <option value="AL">Alagoas (AL)</option>
                                        <option value="AP">Amapá (AP)</option>
                                        <option value="AM">Amazonas (AM)</option>
                                        <option value="BA">Bahia (BA)</option>
                                        <option value="CE">Ceará (CE)</option>
                                        <option value="DF">Distrito Federal (DF)</option>
                                        <option value="ES">Espírito Santo (ES)</option>
                                        <option value="GO">Goiás (GO)</option>
                                        <option value="MA">Maranhão (MA)</option>
                                        <option value="MT">Mato Grosso (MT)</option>
                                        <option value="MS">Mato Grosso do Sul (MS)</option>
                                        <option value="MG">Minas Gerais (MG)</option>
                                        <option value="PA">Pará (PA) </option>
                                        <option value="PB">Paraíba (PB)</option>
                                        <option value="PR">Paraná (PR)</option>
                                        <option value="PE">Pernambuco (PE)</option>
                                        <option value="PI">Piauí (PI)</option>
                                        <option value="RJ">Rio de Janeiro (RJ)</option>
                                        <option value="RN">Rio Grande do Norte (RN)</option>
                                        <option value="RS">Rio Grande do Sul (RS)</option>
                                        <option value="RO">Rondônia (RO)</option>
                                        <option value="RR">Roraima (RR)</option>
                                        <option value="SC">Santa Catarina (SC)</option>
                                        <option value="SP">São Paulo (SP)</option>
                                        <option value="SE">Sergipe (SE)</option>
                                        <option value="TO">Tocantins (TO)</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button v-show="!editmode" type="button" class="btn btn-info" @click="addCliente()">
                            <span><i class="fa fa-floppy-o" aria-hidden="true"></i> Cadastrar</span>    
                        </button>
                        <button v-show="editmode" type="button" class="btn btn-info" @click="editarCliente()">
                            <span><i class="fa fa-floppy-o" aria-hidden="true"></i> Editar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    class Errors{
        constructor(){
            this.errors = {};
        }

        get(field){
            if(this.errors[field]){
                return this.errors[field][0];
            }
        }

        record(errors){
            this.errors = errors.errors;
        }
    }

export default {
    props: ['cliente', 'editmode'],
    data(){
        return {
            errors : []           
        }
    },
    mounted(){
        $("#divErrors").hide();
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
                    $("#divErrors").append($("<span>").css({ "width" : "100%",
                                                             "float" : "left",
                                                             "position" : "relative"}).html(sErro));
                    $("#divErrors").show();
                });
            });
        },
        limpaForm(){
            this.cliente.nome = ''; 
            this.cliente.cpf_cnpj= '';
            this.cliente.endereco = '';  
            this.cliente.num = '';
            this.cliente.bairro = ''; 
            this.cliente.cep =  ''; 
            this.cliente.cidade =  '';   
            this.cliente.estado =  '';
        },
        editarCliente(){
            $("#divErrors span").remove();
            $("#divErrors").hide();
            $("#loading").fadeIn('fast');
            axios.put(window.BaseUrl+'/../api/clientes/'+this.cliente.id, this.cliente).then(response => {
                toast({
                    type: 'success',
                    title: 'Cliente alterado com sucesso.'
                });
                this.$emit('clienteadicionado');
                $("#loading").fadeOut('fast');
            }).catch(error => {
                this.preencheErros(error.response.data.errors);
                toast({
                    type: 'error',
                    title: 'Erro ao alterar cliente.'
                });   
                $("#loading").fadeOut('fast');             
            });
        },
        addCliente(){
            $("#divErrors span").remove();
            $("#divErrors").hide();
            $("#loading").fadeIn('fast');
            axios.post(window.BaseUrl+'/../api/clientes', this.cliente).then(response => {
                toast({
                    type: 'success',
                    title: 'Cliente cadastrado com sucesso.'
                });  
                // this.$emit('clientecadastrado');
                $("#loading").fadeOut('fast');
                this.$emit('clienteadicionado');
                this.limpaForm();
            }).catch(error => {
                this.preencheErros(error.response.data.errors);
                toast({
                    type: 'error',
                    title: 'Erro ao cadastrar cliente.'
                });
                $("#loading").fadeOut('fast');                
            });
        }
    }
}
</script>
<style>

</style>
