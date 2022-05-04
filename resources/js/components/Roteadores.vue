<template>
    <!-- Aqui, como veio do blade, tem que tirar toda codificação PHP -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!--Inicio do card de busca  -->
                <card-component titulo="Busca de roteadores">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp"
                                    texto-ajuda=" Opcional. Informe o ID do roteador">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                        placeholder="ID" v-model="busca.id" />
                                </input-container-component>
                            </div>

                            <div class="col mb-3">
                                <input-container-component titulo="Marca do Roteador" id="inputMarca"
                                    id-help="marcaHelp" texto-ajuda=" Opcional. Informe a marca do roteador">
                                    <input type="text" class="form-control" id="inputMarca" aria-describedby="marcaHelp"
                                        placeholder="Marca do roteador" v-model="busca.marca" />
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

                <!-- Inicio do card de listagem de roteadores -->
                <card-component titulo="Relação de roteadores">
                    <template v-slot:conteudo>
                        <!-- Instanciando o componente Table.vue -->
                        <table-component :dados="roteadores.data" :visualizar="{
                            visivel: true,
                            dataToggle: 'modal',
                            dataTarget: '#modalRoteadorVisualizar',
                        }" :atualizar="{
    visivel: true,
    dataToggle: 'modal',
    dataTarget: '#modalRoteadorAtualizar',
}" :remover="{
    visivel: true,
    dataToggle: 'modal',
    dataTarget: '#modalRoteadorRemover',
}" :titulos="{
    id: { titulo: 'Id', tipo: 'texto' },
    antena_id: { titulo: 'Nome da antena', tipo: 'text' },
    marca: { titulo: 'Marca', tipo: 'texto' },
    //banda: { titulo: 'Banda', tipo: 'texto' },
    //datanota: { titulo: 'Data da nota', tipo: 'texto' },
    //macaddress: { titulo: 'Endereço mac', tipo: 'texto' },
    modelo: { titulo: 'Modelo', tipo: 'texto' },
    //notafiscal: { titulo: 'Nota fiscal', tipo: 'texto' },
    //serial: { titulo: 'Serial', tipo: 'texto' },
    //situacao: { titulo: 'Situação', tipo: 'texto' },
    //observacao: { titulo: 'Observação', tipo: 'texto' },
    imagem: { titulo: 'Imagem', tipo: 'imagem' },
    //created_at: { titulo: 'Criação', tipo: 'data' },
    //updated_at: { titulo: 'Data da atualização', tipo: 'data' },
}"></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="(l, key) in roteadores.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <!-- v-html: Para que todds os caracteres html sejam interpretados -->
                                        <a class="page-link" v-html="l.label"> </a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#modalRoteador">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </template>
                </card-component>

                <!-- Fim do card de listagem de roteadores -->
            </div>
        </div>

        <!-- Aqui é feito a instância do componente/modal "Modal.vue", para inclusão -->
        <!-- Inicio do modal de "inclusão"  -->
        <modal-component id="modalRoteador" titulo="Adicionar roteador">
            <template v-slot:alertas>
                <!-- v-if: renderização condicional -->
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso"
                    v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes"
                    titulo="Erro ao tentar cadastrar o roteador" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="" id="marca" id-help="marcaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="marca" aria-describedby="marcaHelp"
                            placeholder="Marca do roteador" v-model="marca" />
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
                    <input-container-component titulo="" id="datanota" id-help="datanotaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="date" class="form-control" id="datanota" aria-describedby="datanotaHelp"
                            placeholder="Data da nota" v-model="datanota" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="macaddress" id-help="macaddressHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="macaddress" aria-describedby="macaddressHelp"
                            placeholder="Endereço mac" v-model="macaddress" />
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
                    <input-container-component titulo="" id="notafiscal" id-help="notafiscalHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="notafiscal" aria-describedby="Help"
                            placeholder="Nota fiscal" v-model="notafiscal" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="serial" id-help="serialHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="serial" aria-describedby="Help" placeholder="Serial"
                            v-model="serial" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="situacao" id-help="situacaoHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="situacao" aria-describedby="situacaoHelp"
                            placeholder="Situacao" v-model="situacao" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="observacao" id-help="observacaoHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="observacao" aria-describedby="observacaoHelp"
                            placeholder="Observação" v-model="observacao" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novaImagem" id-help="novaImagemHelp"
                        texto-ajuda=" Carregue uma imagem no formato PNG">
                        <!-- Diretiva v-on(@) para evento "change(alteração)" -->
                        <input type="file" class="form-control-file" id="novaImagem" aria-describedby="novaImagemHelp"
                            placeholder="Selecione uma imagem" @change="carregarImagem($event)" />
                    </input-container-component>
                    {{ arquivoImagem }}
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
        <modal-component id="modalRoteadorRemover" titulo="Remover roteador">
            <template v-slot:alertas> </template>

            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled />
                </input-container-component>

                <input-container-component titulo="Marca do roteador">
                    <input type="text" class="form-control" :value="$store.state.item.marca" disabled />
                </input-container-component>

                <!--  <input-container-component titulo="Marca">
                    <input type="text" class="form-control" :value="$store.state.item.marca" disabled />
                </input-container-component> -->

                <input-container-component titulo="Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.modelo" disabled />
                </input-container-component>
            </template>

            <template v-slot:rodape>
                <button type=" button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
                <button type=" button" class="btn btn-danger" @click="remover()">Remover</button>
            </template>
        </modal-component>

        <!-- Aqui é feito a instância do componente/modal "Modal.vue", para visualização(detalhes) -->
        <!-- Inicio do modal de visualização(detalhes) -->
        <modal-component id="modalRoteadorVisualizar" titulo="Visualizar roteador">
            <template v-slot:alertas> </template>

            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled />
                </input-container-component>

                <input-container-component titulo="Nome da antena">
                    <input type="text" class="form-control" :value="$store.state.item.antena_id" disabled />
                </input-container-component>

                <input-container-component titulo="Imagem">
                    <img :src="'storage/' + $store.state.item.imagem" v-if="$store.state.item.imagem" />
                </input-container-component>

                <input-container-component titulo="Data da criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled />
                </input-container-component>

                <input-container-component titulo="Banda">
                    <input type="text" class="form-control" :value="$store.state.item.banda" disabled />
                </input-container-component>

                <input-container-component titulo="Data da nota">
                    <input type="text" class="form-control" :value="$store.state.item.datanota" disabled />
                </input-container-component>

                <input-container-component titulo="Marca">
                    <input type="text" class="form-control" :value="$store.state.item.marca" disabled />
                </input-container-component>

                <input-container-component titulo="Endereço MAC">
                    <input type="text" class="form-control" :value="$store.state.item.macaddress" disabled />
                </input-container-component>

                <input-container-component titulo="Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.modelo" disabled />
                </input-container-component>

                <input-container-component titulo="Nota fiscal">
                    <input type="text" class="form-control" :value="$store.state.item.notafiscal" disabled />
                </input-container-component>

                <input-container-component titulo="Serial">
                    <input type="text" class="form-control" :value="$store.state.item.serial" disabled />
                </input-container-component>

                <input-container-component titulo="Situação">
                    <input type="text" class="form-control" :value="$store.state.item.situacao" disabled />
                </input-container-component>

                <input-container-component titulo="Observação">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled />
                </input-container-component>

                <input-container-component titulo="Data da criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled />
                </input-container-component>

                <input-container-component titulo="Ultima atualização">
                    <input type="text" class="form-control" :value="$store.state.item.updated_at" disabled />
                </input-container-component>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
            </template>
        </modal-component>
        <!-- Fim do modal de visualização(detalhes) -->

        <!-- Aqui é feito a instância do componente/modal "Modal.vue", para atualização -->
        <!-- Inicio do modal de "atualização"  -->
        <modal-component id="modalRoteadorAtualizar" titulo="Atualizar roteador">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação com sucesso" :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="" id="marca" id-help="marcaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="marca" aria-describedby="marcaHelp"
                            placeholder="Marca do roteador" v-model="$store.state.item.marca" />
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
                    <input-container-component titulo="" id="datanota" id-help="datanotaHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="date" class="form-control" id="datanota" aria-describedby="datanotaHelp"
                            placeholder="Data da nota" v-model="datanota" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="macaddress" id-help="macaddressHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="macaddress" aria-describedby="macaddressHelp"
                            placeholder="Endereço mac" v-model="macaddress" />
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
                    <input-container-component titulo="" id="notafiscal" id-help="notafiscalHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="notafiscal" aria-describedby="Help"
                            placeholder="Nota fiscal" v-model="notafiscal" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="serial" id-help="serialHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="serial" aria-describedby="Help" placeholder="Serial"
                            v-model="serial" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="situacao" id-help="situacaoHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="situacao" aria-describedby="situacaoHelp"
                            placeholder="Situacao" v-model="situacao" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="" id="observacao" id-help="observacaoHelp" texto-ajuda="">
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input type="text" class="form-control" id="observacao" aria-describedby="observacaoHelp"
                            placeholder="Observação" v-model="observacao" />
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
                    <!-- {{ arquivoImagem }} -->
                </div>
               <!--  {{ $store.state.item }} -->
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
                <!-- Diretiva v-on(@) para evento "click(acionar)" -->
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>
        <!-- Fim do modal de atualização -->
    </div>
</template>

<script>
export default {
    /* Propriedades computadas */
    computed: {
        token() {
            /* O método "find()"" retorna uma posição do array, somente se a mesma retornar "true",
                                       ou seja, que comece com parâmetro do método "includes()"" */
            let token = document.cookie.split(";").find((indice) => {
                return indice.includes("token=");
            });

            /* Pegando a posição "1" do array, que é somente o token atribuindo */
            token = token.split("=")[1];

            /* Concatenando essa string com o próprio token em si */
            token = "Bearer " + token;

            return token;
        },
    },
    data() {
        return {
            urlBase: "http://localhost:8000/api/v1/roteadores",
            urlPaginacao: "",
            urlFiltro: "",
            marca: "",
            banda: "",
            datanota: "",
            macaddress: "",
            modelo: "",
            notafiscal: "",
            serial: "",
            situacao: "",
            observacao: "",
            arquivoImagem: [],
            transacaoStatus: "",
            transacaoDetalhes: [],
            roteadores: { data: [] },
            busca: { id: "", marca: "" },
        };
    },
    methods: {
        atualizar() {
            /* Criando um formulário programático, para uma requisição http */
            let formData = new FormData();
            formData.append("_method", "patch");
            formData.append("marca", this.$store.state.item.marca);

            /*  if (this.banda) {
              formData.append("banda", this.$store.state.item.banda);
            } */

            if (this.arquivoImagem[0]) {
                formData.append("imagem", this.arquivoImagem[0]);
            }

            let url = this.urlBase + "/" + this.$store.state.item.id;

            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                    Accept: "application/json",
                    Authorization: this.token,
                },
            };

            /* Axios: biblioteca javascript que já vem instalada quando iniciamos
                                             projetos front-end no framework laravel.
                                             Ela realiza as requisições baseando-se em promises,
                                             o que nos ajuda a ter um código realmente assíncrono.
                                             É um cliente http */
            axios
                .post(url, formData, config)
                .then((response) => {
                    this.$store.state.transacao.status = "sucesso";
                    this.$store.state.transacao.mensagem = 'Registro de roteador atualizado com sucesso!';

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

            let config = {
                headers: {
                    /*  "Content-Type": "multipart/form-data", */
                    Accept: "application/json",
                    Authorization: this.token,
                },
            };

            let url = this.urlBase + "/" + this.$store.state.item.id;

            axios
                .post(url, formData, config)
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
        carregarLista() {
            let url = this.urlBase + "?" + this.urlPaginacao + this.urlFiltro;

            console.log(url);
            /* Recebendo um "objeto literal":
                                 Um objeto literal é composto por um par de chaves " { } ",
                                 que envolve uma ou mais propriedades. Cada propriedade segue
                                 o formato " nome: valor " e devem ser separadas por vírgula. */
            let config = {
                headers: {
                    /* "Content-Type": "multipart/form-data", */
                    Accept: "application/json",
                    Authorization: this.token,
                },
            };

            /* Axios: biblioteca javascript que já vem instalada quando iniciamos
                                 projetos front-end no framework laravel.
                                 Ela realiza as requisições baseando-se em promises,
                                 o que nos ajuda a ter um código realmente assíncrono.
                                 É um cliente http */
            axios
                .get(url, config)
                .then((response) => {
                    this.roteadores = response.data;

                    console.log(this.roteadores);
                })
                .catch((errors) => {
                    console.log(errors);
                });
        },

        carregarImagem(e) {
            this.arquivoImagem = e.target.files;
        },
        salvar() {
            console.log(this.marca, this.arquivoImagem[0]);

            /* Objeto formData: Instanciando um formulário para definir seus atributos */
            let formData = new FormData();
            /* Agora atribuindo valores ao formulário */
            formData.append("marca", this.marca);
            formData.append("banda", this.banda);
            formData.append("datanota", this.datanota);
            formData.append("macaddress", this.macaddress);
            formData.append("modelo", this.modelo);
            formData.append("notafiscal", this.notafiscal);
            formData.append("serial", this.serial);
            formData.append("situacao", this.situacao);
            formData.append("observacao", this.observacao);

            formData.append("imagem", this.arquivoImagem[0]);

            /* Recebendo um "objeto literal":
                                       Um objeto literal é composto por um par de chaves " { } ",
                                       que envolve uma ou mais propriedades. Cada propriedade segue
                                       o formato " marca: valor " e devem ser separadas por vírgula. */
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                    Accept: "application/json",
                    Authorization: this.token,
                },
            };

            /* Axios: biblioteca javascript que já vem instalada quando iniciamos
                                        projetos front-end no framework laravel.
                                        Ela realiza as requisições baseando-se em promises,
                                        o que nos ajuda a ter um código realmente assíncrono.
                                        É um cliente http */
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
};
</script>
