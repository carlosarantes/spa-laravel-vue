<template>
    <div class="p-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-info btn-block" @click="modalNovaVenda()">
                            <span><i class="fa fa-plus" aria-hidden="true"></i> Nova Venda</span>
                        </button>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-info btn-block" @click="getVendas()">
                            <span><i class="fa fa-refresh" aria-hidden="true"></i> Recarregar</span>
                        </button>   
                    </div>
                    <div class="col-lg-8 pull-right">
                        <input type="text" class="form-control" placeholder="Filtre por data ou cliente" @input="filtro = $event.target.value" />
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mt-3 mb-4">
                    <CardInformativo classe="verde" titulo="Vendas" :numero="total_vendas" 
                                icone="fa-shopping-cart" texto="Continue se empenhando para melhorar esse numero." />

                    <CardInformativo classe="azul" titulo="Valor total" :numero="'R$ '+formatarValor(valor_total_vendas)" 
                                icone="fa-usd" texto="Esse é o valor total, referente a soma de todas as vendas, muito bem :D." />

                    <CardInformativo classe="vermelho" titulo="Ticket Médio" :numero="'R$ '+formatarValor(ticket_medio)" 
                                icone="fa-money" texto="Este é o ticket médio, um valor médio das vendas realizadas no sistema." />
                </div>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <a href="javascript:;" @click="orderedVendas($event, 0)">Data da Venda</a>
                            </th>
                            <th>
                                <a href="javascript:;" @click="orderedVendas($event, 1)">Cliente</a>
                            </th>
                            <th class="text-center">
                                <a href="javascript:;" @click="orderedVendas($event, 2)">Valor Total</a>
                            </th>
                            <th width="95px" v-show="$gate.isAdmin()">Comprovante</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr v-for="venda in filtroVendas" :key="venda.id">
                            <td class="text-center">{{ venda.data_venda }}</td>
                            <td>{{ venda.nome_cliente }} <strong>CPF: </strong> {{ venda.cpf_cliente }}</td>
                            <td class="text-center">R$ {{ venda.valor_total }}</td>
                            <td v-show="$gate.isAdmin()">
                                <button type="button" class="btn btn-dark btn-block" @click="gerarComprovante(venda)">
                                    <i class="fa fa-file-text" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <VendasForm />
        <ComprovanteVenda :venda="venda_selecionada" />
    </div>
</template>

<script>
import VendasForm from './VendasForm';
import ComprovanteVenda from './ComprovanteVenda';
import CardInformativo from '../../elements/CardInformativo';

export default {
    components:{
        VendasForm,
        ComprovanteVenda,
        CardInformativo
    },
    data(){
        return {
            filtro : '',
            sortProperties : [
                { propriedade : 'data_venda', direcao : 'asc' },
                { propriedade : 'nome_cliente', direcao : 'asc' },
                { propriedade : 'valor_total', direcao : 'asc' }
            ],
            total_vendas : 0,
            valor_total_vendas : 0.00,
            ticket_medio : 0.00,
            vendas : [],
            venda_selecionada : { id : 0, data_venda : '', 
                                    nome_cliente: '', cpf_cliente : '', 
                                    valor_total : 0.00 }
        }
    },
    mounted(){
        this.getVendas();
    },
    computed:{
        filtroVendas(){
            if(this.filtro){
                let exp = new RegExp(this.filtro.trim(), 'i');
                return this.vendas.filter(venda => exp.test(venda.data_venda+'|'+venda.nome_cliente+'|'+venda.cpf_cliente));
            }else{
                return this.vendas;
            }
        }
    },
    methods:{
        orderedVendas(ev, posPropriedade) {

            if(this.sortProperties[posPropriedade].direcao == 'asc'){
                this.sortProperties[posPropriedade].direcao = 'desc';
            }else{
                this.sortProperties[posPropriedade].direcao = 'asc';
            }
            let propriedade = this.sortProperties[posPropriedade];
            this.vendas = _.orderBy(this.vendas, propriedade.propriedade, propriedade.direcao)
        },
        formatarValor(valor) {
            let val = (valor/1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        atualizaValores(){
            this.total_vendas = this.vendas.length;
            this.valor_total_vendas = 0;
            for(var k in this.vendas){
                this.valor_total_vendas += this.vendas[k].valor_total;
            }
            this.ticket_medio = this.valor_total_vendas/this.total_vendas;
        },
        gerarComprovante(venda){
            this.venda_selecionada = venda;
            $('#modalComprovante').modal('show');
        },
        modalNovaVenda(){
           $('#addNovaVenda').modal('show');
        },
        getVendas(){
            $("#loading").fadeIn('fast');
            axios.get(window.BaseUrl+'/../api/pedidos/get-vendas')
                .then(response => {
                    this.vendas = response.data;
                    this.atualizaValores();
                    $("#loading").fadeOut('fast');
                });
        }
    }
}
</script>

<style>

</style>