<template>
    <!-- Aqui, como veio do blade, tem que tirar toda codificação PHP -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!--Inicio do card de busca  -->
                <card-component titulo="Busca de antenas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp"
                                    texto-ajuda=" Opcional. Informe o ID da antena">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                        placeholder="ID" v-model="busca.id" />
                                </input-container-component>
                            </div>

                            <div class="col mb-3">
                                <input-container-component titulo="Nome da antena" id="inputNome" id-help="nomeHelp"
                                    texto-ajuda=" Opcional. Informe o nome da antena">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp"
                                        placeholder="Nome da antena" v-model="busca.nome" />
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="Submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">
                            Pesquisar
                        </button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->

                <!-- Inicio do card de listagem de antenas -->
                <card-component titulo="Relação de antenas">
                    <template v-slot:conteudo>
                        <!-- Instanciando o componente Table.vue -->
                        <table-component :dados="antenas.data" :visualizar="{
                            visivel: true,
                            dataToggle: 'modal',
                            dataTarget: '#modalAntenaVisualizar',
                        }" :atualizar="{
    visivel: true,
    dataToggle: 'modal',
    dataTarget: '#modalAntenaAtualizar',
}" :remover="{
    visivel: true,
    dataToggle: 'modal',
    dataTarget: '#modalAntenaRemover',
}" :titulos="{
    id: { titulo: 'Id', tipo: 'texto' },
    nome: { titulo: 'Nome', tipo: 'texto' },
    banda: { titulo: 'Banda', tipo: 'texto' },
    //datanota: { titulo: 'Data da nota', tipo: 'date' },
    //diametro: { titulo: 'Diametro', tipo: 'texto' },
    //marca: { titulo: 'Marca', tipo: 'texto' },
    modelo: { titulo: 'Modelo', tipo: 'texto' },
    //notafiscal: { titulo: 'Nota fiscal', tipo: 'texto' },
    //observacao: { titulo: 'Observações', tipo: 'texto' },
    //situacao: { titulo: 'Situação', tipo: 'texto' },
    imagem: { titulo: 'Imagem', tipo: 'imagem' },
    //created_at: { titulo: 'Criação', tipo: 'data' },
    //updated_at: { titulo: 'Data da atualização', tipo: 'data' },
}"></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="(l, key) in antenas.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <!-- v-html: Para que todds os caracteres html sejam interpretados -->
                                        <a class="page-link" v-html="l.label"> </a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#modalAntena">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim do card de listagem de antenas -->
            </div>
        </div>

        <!-- Aqui é feito a instância do componente/modal "Modal.vue", para inclusão -->
        <!-- Inicio do modal de "inclusão"  -->
        <modal-component id="modalAntena" titulo="Adicionar antena">
            <template v-slot:alertas>
                <!-- v-if: renderização condicional -->
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso"
                    v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a antena"
                    v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="" id="nome" id-help="nomeHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="nome" aria-describedby="nomeHelp"
                            placeholder="Nome da antena" v-model="nomeAntena" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="banda" id-help="bandaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="banda" aria-describedby="bandaHelp"
                            placeholder="Banda" v-model="banda" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="notafiscal" id-help="notafiscalHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="notafiscal" aria-describedby="notafiscalHelp"
                            placeholder="Nota fiscal" v-model="notafiscal" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="datanota" id-help="datanotaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="date" class="form-control" id="datanota" aria-describedby="datanotaHelp"
                            placeholder="Data da nota" v-model="datanota" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="marca" id-help="marcaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="marca" aria-describedby="marcaHelp"
                            placeholder="Marca" v-model="marca" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="modelo" id-help="modeloHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="modelo" aria-describedby="modeloHelp"
                            placeholder="Modelo" v-model="modelo" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="situacao" id-help="situacaoHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="situacao" aria-describedby="situacaoHelp"
                            placeholder="Situação" v-model="situacao" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="diametro" id-help="diametroHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="diametro" aria-describedby="diametroHelp"
                            placeholder="Diâmetro" v-model="diametro" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="observacao" id-help="observacaoHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="observacao" aria-describedby="observacaoHelp"
                            placeholder="observacao" v-model="observacao" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novaImagem" id-help="novaImagemHelp"
                        texto-ajuda=" Carregue uma imagem no formato PNG">
                        <!-- Diretiva v-on(@) para evento "change(alteração)" -->
                        <input type="file" class="form-control-file" id="novaImagem" aria-describedby="novaImagemHelp"
                            placeholder="Selecione uma imagem" @change="carregarImagem($event)" />
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
                <!-- Diretiva v-on(@) para evento "click(acionar)" -->
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- Fim do modal de inclusão -->

        <!-- Aqui é feito a instância do componente/modal "Modal.vue", para remoção -->
        <!-- Inicio do modal de remoção -->
        <modal-component id="modalAntenaRemover" titulo="Remover antena">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação com sucesso" :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <!-- "v-if()": Renderização condicional. -->
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled />
                </input-container-component>

                <input-container-component titulo="Nome da antena">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled />
                </input-container-component>

                <!--  <input-container-component titulo="Marca">
                    <input type="text" class="form-control" :value="$store.state.item.marca" disabled />
                </input-container-component>
                <input-container-component titulo="Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.modelo" disabled />
                </input-container-component> -->
            </template>

            <template v-slot:rodape>
                <button type=" button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
                <button type=" button" class="btn btn-danger" @click="remover()"
                    v-if="$store.state.transacao.status != 'sucesso'">
                    Remover
                </button>
            </template>
        </modal-component>
        <!-- Fim do modal de remoção -->

        <!-- Aqui é feito a instância do componente/modal "Modal.vue", para visualização(detalhes) -->
        <!-- Inicio do modal de visualização(detalhes) -->
        <modal-component id="modalAntenaVisualizar" titulo="Visualizar antena">
            <template v-slot:alertas> </template>

            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled />
                </input-container-component>

                <input-container-component titulo="Nome da antena">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled />
                </input-container-component>

                <input-container-component titulo="Banda">
                    <input type="text" class="form-control" :value="$store.state.item.banda" disabled />
                </input-container-component>

                <input-container-component titulo="Data da nota">
                    <input type="text" class="form-control" :value="$store.state.item.datanota" disabled />
                </input-container-component>

                <input-container-component titulo="Diâmetro">
                    <input type="text" class="form-control" :value="$store.state.item.diametro" disabled />
                </input-container-component>

                <input-container-component titulo="Marca">
                    <input type="text" class="form-control" :value="$store.state.item.marca" disabled />
                </input-container-component>

                <input-container-component titulo="Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.modelo" disabled />
                </input-container-component>

                <input-container-component titulo="Nota fiscal">
                    <input type="text" class="form-control" :value="$store.state.item.notafiscal" disabled />
                </input-container-component>

                <input-container-component titulo="Observação">
                    <input type="text" class="form-control" :value="$store.state.item.observacao" disabled />
                </input-container-component>

                <input-container-component titulo="Situação">
                    <input type="text" class="form-control" :value="$store.state.item.situacao" disabled />
                </input-container-component>

                <input-container-component titulo="Imagem">
                    <img :src="'storage/' + $store.state.item.imagem" v-if="$store.state.item.imagem" />
                </input-container-component>

                <input-container-component titulo="Data da criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled />
                </input-container-component>

                <input-container-component titulo="Ultima atualização">
                    <input type="text" class="form-control" :value="$store.state.item.updated_at" disabled />
                </input-container-component>
            </template>

            <template v-slot:rodape>
                <button type=" button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
            </template>
        </modal-component>
        <!-- Fim do modal de visualização(detalhes) -->

        <!-- Aqui é feito a instância do componente/modal "Modal.vue", para atualização -->
        <!-- Inicio do modal de "atualização"  -->
        <modal-component id="modalAntenaAtualizar" titulo="Atualizar antena">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação com sucesso" :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="" id="nome" id-help="nomeHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="nome" aria-describedby="nomeHelp"
                            placeholder="Nome da antena" v-model="$store.state.item.nome" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="banda" id-help="bandaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="banda" aria-describedby="bandaHelp"
                            placeholder="Banda" v-model="$store.state.item.banda" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="notafiscal" id-help="notafiscalHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="notafiscal" aria-describedby="notafiscalHelp"
                            placeholder="Nota fiscal" v-model="notafiscal" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="datanota" id-help="datanotaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="date" class="form-control" id="datanota" aria-describedby="datanotaHelp"
                            placeholder="Data da nota" v-model="datanota" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="marca" id-help="marcaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="marca" aria-describedby="marcaHelp"
                            placeholder="Marca" v-model="marca" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="modelo" id-help="modeloHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="modelo" aria-describedby="modeloHelp"
                            placeholder="Modelo" v-model="modelo" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="situacao" id-help="situacaoHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="situacao" aria-describedby="situacaoHelp"
                            placeholder="Situação" v-model="situacao" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="diametro" id-help="diametroHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="diametro" aria-describedby="diametroHelp"
                            placeholder="Diâmetro" v-model="diametro" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="observacao" id-help="observacaoHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="observacao" aria-describedby="observacaoHelp"
                            placeholder="observacao" v-model="observacao" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp"
                        texto-ajuda=" Carregue uma imagem no formato PNG">
                        <!-- Diretiva v-on(@) para evento "change(alteração)" -->
                        <input type="file" class="form-control-file" id="atualizarImagem"
                            aria-describedby="atualizarImagemHelp" placeholder="Selecione uma imagem"
                            @change="carregarImagem($event)" />
                    </input-container-component>
                </div>

                <!--  {{ $store.state.item }} -->
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
                <!-- Diretiva v-on(@) para evento "click(acionar)" -->
                <button type="button" class="btn btn-primary" @click="atualizar()">
                    Atualizar
                </button>
            </template>
        </modal-component>
        <!-- Fim do modal de atualização -->
    </div>
</template>

<script>
import axios from "axios";
import Alert from "./Alert.vue";
export default {
    data() {
        return {
            urlBase: "http://localhost:8000/api/v1/antenas",
            urlPaginacao: "",
            urlFiltro: "",
            id: "",
            created_at: "",
            nomeAntena: "",
            banda: "",
            datanota: "",
            diametro: "",
            marca: "",
            modelo: "",
            notafiscal: "",
            observacao: "",
            situacao: "",
            arquivoImagem: [],
            transacaoStatus: "",
            transacaoDetalhes: {},
            antenas: { data: [] },
            busca: { id: "", nome: "" },
        };
    },
    methods: {
        atualizar() {
            /* Criando um formulário programático, para uma requisição http */
            let formData = new FormData();
            formData.append("_method", "patch");
            formData.append("nome", this.$store.state.item.nome);
            /* if (this.banda) {
                    formData.append("banda", this.$store.state.item.banda);
                  } */
            if (this.arquivoImagem[0]) {
                formData.append("imagem", this.arquivoImagem[0]);
            }
            let url = this.urlBase + "/" + this.$store.state.item.id;
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };
            /* Axios: biblioteca javascript que já vem instalada quando iniciamos
               projetos front-end no framework laravel.
               Ela realiza as requisições baseando-se em promises,
               o que nos ajuda a ter um código realmente assíncrono.
               É o cliente http que estamos usando no front da aplicação */
            axios
                .post(url, formData, config)
                .then((response) => {
                    this.$store.state.transacao.status = "sucesso";
                    this.$store.state.transacao.mensagem =
                        "Registro de antena atualizado com sucesso!";
                    //limpar o campo de seleção de arquivos
                    atualizarImagem.value = "";
                    this.carregarLista();
                })
                .catch((errors) => {
                    this.$store.state.transacao.status = "erro";
                    this.$store.state.transacao.mensagem = errors.response.data.message;
                    this.$store.state.transacao.dados = errors.response.data.errors;
                });
        },
        carregarLista() {
            let url = this.urlBase + "?" + this.urlPaginacao + this.urlFiltro;
            console.log(url);
            /* Recebendo um "objeto literal":
                                                   Um objeto literal é composto por um par de chaves " { } ",
                                                   que envolve uma ou mais propriedades. Cada propriedade segue
                                                   o formato " nome: valor " e devem ser separadas por vírgula. */

            /* Axios: biblioteca javascript que já vem instalada quando iniciamos
               projetos front-end no framework laravel.
               Ela realiza as requisições baseando-se em promises,
               o que nos ajuda a ter um código realmente assíncrono.
               É o cliente http que estamos usando no front da aplicação */
            axios
                .get(url)
                .then((response) => {
                    this.antenas = response.data;
                    console.log(this.antenas);
                })
                .catch((errors) => {
                    console.log(errors);
                });
        },
        carregarImagem(e) {
            this.arquivoImagem = e.target.files;
        },
        remover() {
            /* Variável recebe o retorno do "confirm()", do próprio navegador */
            let confirmacao = confirm("Deseja remover esse registro?");
            if (!confirmacao) {
                return false;
            }
            /* Objeto formData: Instanciando um formulário para definir seus atributos */
            /* Um formulário HTML de modo programático */
            let formData = new FormData();
            formData.append("_method", "delete");

            let url = this.urlBase + "/" + this.$store.state.item.id;
            axios
                .post(url, formData)
                .then((response) => {
                    this.$store.state.transacao.status = "sucesso";
                    this.$store.state.transacao.mensagem = response.data.msg;
                    this.carregarLista();
                })
                .catch((errors) => {
                    this.$store.state.transacao.status = "erro";
                    this.$store.state.transacao.mensagem = errors.response.data.erro;
                });
        },
        pesquisar() {
            let filtro = "";
            for (let chave in this.busca) {
                if (this.busca[chave]) {
                    if (filtro != "") {
                        filtro += ";";
                    }
                    filtro += chave + ":like:" + this.busca[chave];
                }
            }
            if (filtro != "") {
                this.urlPaginacao = "page=1";
                this.urlFiltro = "&filtro=" + filtro;
            } else {
                this.urlFiltro = "";
            }
            this.carregarLista();
        },
        paginacao(l) {
            if (l.url) {
                /* Ajustando a url de consulta com o parâmetro de página */
                //this.urlBase = l.url;
                this.urlPaginacao = l.url.split("?")[1];
                /* Requisitando novamente os dados para a API, baseando na url atualizada */
                this.carregarLista();
            }
        },
        salvar() {
            console.log(this.nomeAntena, this.arquivoImagem[0]);
            /* Objeto formData: Instanciando um formulário para definir seus atributos */
            /* Um formulário HTML de modo programático */
            let formData = new FormData();
            /* Agora atribuindo valores ao formulário */
            formData.append("id", this.id);
            formData.append("created_at", this.created_at);
            formData.append("nome", this.nomeAntena);
            formData.append("imagem", this.arquivoImagem[0]);
            formData.append("banda", this.banda);
            formData.append("datanota", this.datanota);
            formData.append("diametro", this.diametro);
            formData.append("marca", this.marca);
            formData.append("modelo", this.modelo);
            formData.append("notafiscal", this.notafiscal);
            formData.append("observacao", this.observacao);
            formData.append("situacao", this.situacao);
            /* Recebendo um "objeto literal":
                                                   Um objeto literal é composto por um par de chaves " { } ",
                                                   que envolve uma ou mais propriedades. Cada propriedade segue
                                                   o formato " nome: valor " e devem ser separadas por vírgula. */
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };
            /* Axios: biblioteca javascript que já vem instalada quando iniciamos
                projetos front-end no framework laravel.
                Ela realiza as requisições baseando-se em promises,
                o que nos ajuda a ter um código realmente assíncrono.
                É o cliente http que estamos usando no front da aplicação */
            /* Este método (post()) espera 03 parâmetros: */
            axios
                .post(this.urlBase, formData, config)
                /* Pegando(recuperando) a resposta */
                .then((response) => {
                    this.transacaoStatus = "adicionado";
                    this.transacaoDetalhes = {
                        mensagem: "ID do registro" + response.data.id,
                    };
                    console.log(response);
                })
                /* Se houver êrro */
                .catch((errors) => {
                    this.transacaoStatus = "erro";
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors,
                    };
                    //errors.response.data.message
                });
        },
    },
    /* Ciclo de vida "mounted()", quando o componente estiver totalmente montado */
    mounted() {
        this.carregarLista();
    },
    components: { Alert },
};
</script>
