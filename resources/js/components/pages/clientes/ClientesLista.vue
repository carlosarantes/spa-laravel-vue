<template>
    <div class="p-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-info btn-block" @click="modalNovoCliente()">
                            <span><i class="fa fa-plus" aria-hidden="true"></i> Novo Cliente</span>
                        </button>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-info btn-block" @click="getClientes()">
                            <span><i class="fa fa-refresh" aria-hidden="true"></i> Recarregar</span>
                        </button>
                    </div>
                    <div class="col-lg-8 pull-right">
                        <input type="text" class="form-control" placeholder="Digite sua busca aqui" @input="filtro = $event.target.value" />
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" v-on:clienteadicionado="getClientes()">
                    <thead>
                        <tr>
                            <th>
                                <a href="javacript:;" @click="orderedClientes($event, 0)">Nome</a>
                            </th>
                            <th width="150px" class="text-center">
                                <a href="javascript:;" @click="orderedClientes($event, 1)">
                                    CPF/CNPJ
                                </a>
                            </th> 
                            <th class="text-center">
                                <a href="javascript:;" @click="orderedClientes($event, 2)">
                                    Cidade
                                </a>
                            </th>
                            <th width="95px">Telefones</th>
                            <th width="95px" v-show="$gate.isAdmin()">Editar/Ver</th>
                            <th width="95px" v-show="$gate.isAdmin()">Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cliente in filtroClientes" :key="cliente.id">
                            <td>{{ cliente.nome }}
                            <td class="text-center">{{ cliente.cpf_cnpj }}</td>
                            <td class="text-center">{{ cliente.cidade }}</td>
                            <td>
                                <button type="button" class="btn btn-dark btn-block" @click="listarTelefones(cliente)">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td v-show="$gate.isAdmin()">
                                <button type="button" class="btn btn-info btn-block" @click="abrirModalEdicao(cliente)">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td v-show="$gate.isAdmin()">
                                <button type="button" class="btn btn-danger btn-block" @click="deletarCliente(cliente.id)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <ClientesForm :cliente="cliente_selecionado" :editmode="edit_invoker" />
        <ContatosClienteLista :cliente="cliente_selecionado"  />
    </div>
</template>

<script>
    import ClientesForm from './ClientesForm'
    import ContatosClienteLista from './ContatosClienteLista'
    export default {
        components: {
            ClientesForm,
            ContatosClienteLista
        },
        data(){
            return{
                sortProperties : [
                    { propriedade : 'nome', direcao : 'asc' },
                    { propriedade : 'cpf_cnpj', direcao : 'asc' },
                    { propriedade : 'cidade', direcao : 'asc' }
                ],
                clientes : [],
                filtro: '',
                edit_invoker: false,
                cliente_selecionado: { id : 0, nome : '', cpf_cnpj : '', endereco : '', num : '', bairro : '', cep : '',   cidade : '', estado : '' }           
            }
        },
        computed: {
            filtroClientes(){
                if(this.filtro){
                    let exp = new RegExp(this.filtro.trim(), 'i');
                    return this.clientes.filter(cliente => exp.test(cliente.nome+'|'+cliente.cpf_cnpj+'|'+cliente.cidade));
                }else{
                    return this.clientes;
                }
            }
        },
        methods:{
            orderedClientes(ev, posPropriedade) {
                if(this.sortProperties[posPropriedade].direcao == 'asc'){
                    this.sortProperties[posPropriedade].direcao = 'desc';
                }else{
                    this.sortProperties[posPropriedade].direcao = 'asc';
                }
                let propriedade = this.sortProperties[posPropriedade];
                this.clientes = _.orderBy(this.clientes, propriedade.propriedade, propriedade.direcao)
            },
            abrirModalEdicao(cliente){
                this.edit_invoker = true;
                this.cliente_selecionado = cliente;
                $('#addNew').modal('show');
            },
            getClientes(){
                $("#loading").fadeIn('fast');
                axios.get(window.BaseUrl+'/../api/clientes')
                    .then(response => {
                        this.clientes = response.data;
                        $("#loading").fadeOut('fast');
                    });
            },
            modalNovoCliente(){
                this.edit_invoker = false;
                this.cliente_selecionado = {
                    id : 0,
                    nome : '', 
                    cpf_cnpj : '', 
                    endereco : '',  
                    num : '',
                    bairro : '',  
                    cep : '',  
                    cidade : '',  
                    estado : ''
                };
                $('#addNew').modal('show');
            },
            listarTelefones(cliente){
                // this.$emit('clienteadicionado');
                this.cliente_selecionado = cliente;
                $('#listaTelefones').modal('show');
            },
            deletarCliente(cliente_id){
                swal({
                    title: 'Você tem certeza?',
                    text: "Deletando um usuário você deletara também todos seus contatos",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#015C7B',
                    cancelButtonColor: '#B00020',
                    confirmButtonText: 'Sim, deletar agora!',
                    cancelButtonText: 'Agora não!'
                    }).then((result) => {
                         if(result.value){
                            $("#loading").fadeIn('fast');
                            axios.delete(window.BaseUrl+'/../api/clientes/'+cliente_id)
                                .then(response => {
                                 
                                    toast({
                                        type: 'success',
                                        title: 'Cliente deletado com sucesso'
                                    });
                                    $("#loading").fadeOut('fast');
                                    this.getClientes();
                                })
                                .catch(error => {
                                    
                                    toast({
                                        type: 'error',
                                        title: 'Erro ao deletar cliente'
                                    });
                                });                          
                         }
                    });
            }
        },
        mounted(){
            this.getClientes(); 
           /* this.$on('clienteadicionado', function(){
                this.getClientes(); 
            }); */
        },
        created(){
            
        }
    }
</script>