<template>
  <!-- Aqui, como veio do blade, tem que tirar toda codificação PHP -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!--Inicio do card de busca  -->
        <card-component titulo="Busca de planos">
          <template v-slot:conteudo>
            <div class="form-row">
              <div class="col mb-3">
                <input-container-component
                  titulo="ID"
                  id="inputId"
                  id-help="idHelp"
                  texto-ajuda=" Opcional. Informe o ID do plano"
                >
                  <input
                    type="number"
                    class="form-control"
                    id="inputId"
                    aria-describedby="idHelp"
                    placeholder="ID"
                    v-model="busca.id"
                  />
                </input-container-component>
              </div>

              <div class="col mb-3">
                <input-container-component
                  titulo="Nome do plano"
                  id="inputNome"
                  id-help="nomeHelp"
                  texto-ajuda=" Opcional. Informe o nome do plano"
                >
                  <input
                    type="text"
                    class="form-control"
                    id="inputNome"
                    aria-describedby="nomeHelp"
                    placeholder="Nome do plano"
                    v-model="busca.nome"
                  />
                </input-container-component>
              </div>
            </div>
          </template>

          <template v-slot:rodape>
            <button
              type="Submit"
              class="btn btn-primary btn-sm float-right"
              @click="pesquisar()"
            >
              Pesquisar
            </button>
          </template>
        </card-component>
        <!-- Fim do card de busca -->

        <!-- Inicio do card de listagem de planos -->
        <card-component titulo="Relação de planos">
          <template v-slot:conteudo>
            <!-- Instanciando o componente Table.vue -->
            <table-component
              :dados="planos.data"
              :visualizar="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalPlanoVisualizar',
              }"
              :atualizar="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalPlanoAtualizar',
              }"
              :remover="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalPlanoRemover',
              }"
              :titulos="{
                id: { titulo: 'Id', tipo: 'texto' },
                nome: { titulo: 'Nome', tipo: 'texto' },
                banda: { titulo: 'Banda', tipo: 'texto' },
                //cir: { titulo: 'Cir', tipo: 'texto' },
                //equipamento: { titulo: 'Equipamento', tipo: 'texto' },
                //observacao: { titulo: 'Observação', tipo: 'texto' },
                //valor: { titulo: 'Valor', tipo: 'texto' },
                //valordecusto: { titulo: 'Valor de custo', tipo: 'texto' },
                //valormensal: { titulo: 'Valor mensal', tipo: 'texto' },
                velocmaxdown: { titulo: 'Veloc máxina download', tipo: 'texto' },
                //velocmaxup: { titulo: 'Veloc máxina upload', tipo: 'texto' },
                //velocmindown: { titulo: 'Veloc mínima download', tipo: 'texto' },
                //velocminup: { titulo: 'Veloc mínima upload ', tipo: 'texto' },
                //created_at: { titulo: 'Criação', tipo: 'data' },
                //updated_at: { titulo: 'Data da atualização', tipo: 'data' },
              }"
            ></table-component>
          </template>

          <template v-slot:rodape>
            <div class="row">
              <div class="col-10">
                <paginate-component>
                  <li
                    v-for="(l, key) in planos.links"
                    :key="key"
                    :class="l.active ? 'page-item active' : 'page-item'"
                    @click="paginacao(l)"
                  >
                    <!-- v-html: Para que todds os caracteres html sejam interpretados -->
                    <a class="page-link" v-html="l.label"> </a>
                  </li>
                </paginate-component>
              </div>
              <div class="col">
                <button
                  type="button"
                  class="btn btn-primary btn-sm float-right"
                  data-toggle="modal"
                  data-target="#modalPlano"
                >
                  > Adicionar
                </button>
              </div>
            </div>
          </template>
        </card-component>
        <!-- Fim do card de listagem de planos -->
      </div>
    </div>

    <!-- Aqui é feito a instância do componente/modal "Modal.vue", para inclusão -->
    <!-- Inicio do modal de "inclusão"  -->
    <modal-component id="modalPlano" titulo="Adicionar plano">
      <template v-slot:alertas>
        <!-- v-if: renderização condicional -->
        <alert-component
          tipo="success"
          :detalhes="transacaoDetalhes"
          titulo="Cadastro realizado com sucesso"
          v-if="transacaoStatus == 'adicionado'"
        ></alert-component>
        <alert-component
          tipo="danger"
          :detalhes="transacaoDetalhes"
          titulo="Erro ao tentar cadastrar o plano"
          v-if="transacaoStatus == 'erro'"
        ></alert-component>
      </template>

      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component
            titulo=""
            id="novoPlano"
            id-help="novoPlanoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="novoPlano"
              aria-describedby="novoPlanoHelp"
              placeholder="Nome do plano"
              v-model="nomePlano"
            />
          </input-container-component>
          <!--  {{ nomePlano }} -->
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="banda"
            id-help="bandaHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="banda"
              aria-describedby="bandaHelp"
              placeholder="Banda"
              v-model="banda"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component titulo="" id="cir" id-help="cirHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cir"
              aria-describedby="cirHelp"
              placeholder="Cir"
              v-model="cir"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="equipamento"
            id-help="equipamentoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="equipamento"
              aria-describedby="equipamentoHelp"
              placeholder="Equipamento"
              v-model="equipamento"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="valor"
            id-help="valorHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="valor"
              aria-describedby="valorHelp"
              placeholder="Valor"
              v-model="valor"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="valordecusto"
            id-help="valordecustoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="valordecusto"
              aria-describedby="valordecustoHelp"
              placeholder="Valor de Custo"
              v-model="valordecusto"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="valormensal"
            id-help="valormensalHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="valormensal"
              aria-describedby="valormensalHelp"
              placeholder="Valor Mensal"
              v-model="valormensal"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="velocmaxdown"
            id-help="velocmaxdownHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="velocmaxdown"
              aria-describedby="velocmaxdownlHelp"
              placeholder="Velocidade máxima de download"
              v-model="velocmaxdown"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="velocmaxup"
            id-help="velocmaxupHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="velocmaxup"
              aria-describedby="velocmaxupHelp"
              placeholder="Velocidade máxima de upload"
              v-model="velocmaxup"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="velocmindown"
            id-help="velocmindownHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="velocmindown"
              aria-describedby="velocmindownHelp"
              placeholder="Velocidade minima de download"
              v-model="velocmindown"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="velocminup"
            id-help="velocminupHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="velocminup"
              aria-describedby="velocminupHelp"
              placeholder="Velocidade minima de upload"
              v-model="velocminup"
            />
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
    <modal-component id="modalPlanoRemover" titulo="Remover plano">
      <template v-slot:alertas> </template>

      <template v-slot:conteudo>
        <input-container-component titulo="ID">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.id"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Nome da antena">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.nome"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Banda">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.banda"
            disabled
          />
        </input-container-component>

        <!-- <input-container-component titulo="Modelo">
                    <input type="text" class="form-control" :value="$store.state.item.modelo" disabled />
                </input-container-component> -->
      </template>

      <template v-slot:rodape>
        <button type=" button" class="btn btn-secondary" data-dismiss="modal">
          Fechar
        </button>
        <button type=" button" class="btn btn-danger" @click="remover()">Remover</button>
      </template>
    </modal-component>
    <!-- Fim do modal de remoção -->

    <!-- Aqui é feito a instância do componente/modal "Modal.vue", para visualização(detalhes) -->
    <!-- Inicio do modal de visualização(detalhes) -->
    <modal-component id="modalPlanoVisualizar" titulo="Visualizar plano">
      <template v-slot:alertas> </template>

      <template v-slot:conteudo>
        <input-container-component titulo="ID">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.id"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Nome">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.nome"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Banda">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.banda"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="CIR">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.cir"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Equipamento">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.equipamento"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Observação">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.observacao"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Valor">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.valor"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Valor de custo">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.valordecusto"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Valor mensal">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.valormensal"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Velocidade máxima download">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.velocmaxdown"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Velocidade máxima upload">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.velocmaxup"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Velocidade mínima download">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.velocmindown"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Velocidade mínima upload">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.velocminup"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Data de criação">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.created_at"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Data última alteração">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.updated_at"
            disabled
          />
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
    <modal-component id="modalPlanoAtualizar" titulo="Atualizar plano">
      <template v-slot:alertas> </template>

      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component
            titulo=""
            id="novoPlano"
            id-help="novoPlanoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="novoPlano"
              aria-describedby="novoPlanoHelp"
              placeholder="Nome do plano"
              v-model="$store.state.item.nome"
            />
          </input-container-component>
          <!--  {{ nomePlano }} -->
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="banda"
            id-help="bandaHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="banda"
              aria-describedby="bandaHelp"
              placeholder="Banda"
              v-model="$store.state.item.banda"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component titulo="" id="cir" id-help="cirHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cir"
              aria-describedby="cirHelp"
              placeholder="Cir"
              v-model="$store.state.item.cir"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="equipamento"
            id-help="equipamentoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="equipamento"
              aria-describedby="equipamentoHelp"
              placeholder="Equipamento"
              v-model="$store.state.item.equipamento"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="valor"
            id-help="valorHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="valor"
              aria-describedby="valorHelp"
              placeholder="Valor"
              v-model="$store.state.item.valor"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="valordecusto"
            id-help="valordecustoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="valordecusto"
              aria-describedby="valordecustoHelp"
              placeholder="Valor de Custo"
              v-model="$store.state.item.valordecusto"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="valormensal"
            id-help="valormensalHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="valormensal"
              aria-describedby="valormensalHelp"
              placeholder="Valor Mensal"
              v-model="$store.state.item.valormensal"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="velocmaxdown"
            id-help="velocmaxdownHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="velocmaxdown"
              aria-describedby="velocmaxdownlHelp"
              placeholder="Velocidade máxima de download"
              v-model="$store.state.item.velocmaxdown"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="velocmaxup"
            id-help="velocmaxupHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="velocmaxup"
              aria-describedby="velocmaxupHelp"
              placeholder="Velocidade máxima de upload"
              v-model="$store.state.item.velocmaxup"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="velocmindown"
            id-help="velocmindownHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="velocmindown"
              aria-describedby="velocmindownHelp"
              placeholder="Velocidade minima de download"
              v-model="$store.state.item.velocmindown"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="velocminup"
            id-help="velocminupHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="velocminup"
              aria-describedby="velocminupHelp"
              placeholder="Velocidade minima de upload"
              v-model="$store.state.item.velocminup"
            />
          </input-container-component>
        </div>
        {{ $store.state.item }}
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

    <!--  <button type="button" @click="carregarLista()">Teste</button> -->
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
      urlBase: "http://localhost:8000/api/v1/planos",
      urlPaginacao: "",
      urlFiltro: "",
      nomePlano: "",
      banda: "",
      cir: "",
      equipamento: "",
      observacao: "",
      valor: "",
      valordecusto: "",
      valormensal: "",
      velocmaxdown: "",
      velocmaxup: "",
      velocmindown: "",
      velocminup: "",
      /* arquivoImagem: [], */
      transacaoStatus: "",
      transacaoDetalhes: {},
      planos: { data: [] },
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

      /* if (this.arquivoImagem[0]) {
        formData.append("imagem", this.arquivoImagem[0]);
      } */

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
          console.log("Atualizado", response);
          //limpar o campo de seleção de arquivos
          //atualizarImagem.value = "";
          this.carregarLista();
        })
        .catch((errors) => {
          console.log("Erro de atualização", errors.response);
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
      //console.log(url)

      axios
        .post(url, formData, config)
        .then((response) => {
          console.log("Registro removido com sucesso", response);
          this.carregarLista();
        })
        .catch((errors) => {
          console.log("Êrro na tentativa de remoção do registro", errors.response);
        });
    },
    pesquisar() {
      //console.log(this.busca);

      let filtro = "";

      for (let chave in this.busca) {
        if (this.busca[chave]) {
          //console.log(chave, this.busca[chave]);
          if (filtro != "") {
            filtro += ";";
          }
          filtro += chave + ":like:" + this.busca[chave];
        }
      }
      //console.log(filtro);
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
          this.planos = response.data;

          console.log(this.planos);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    /*  carregarImagem(e) {
                    this.arquivoImagem = e.target.files;
                }, */

    salvar() {
      console.log(this.nomePlano /* this.arquivoImagem[0] */);

      /* Objeto formData: Instanciando um formulário para definir seus atributos */
      let formData = new FormData();
      /* Agora atribuindo valores ao formulário */
      formData.append("nome", this.nomePlano);
      /* formData.append("imagem", this.arquivoImagem[0]); */
      formData.append("banda", this.banda);
      formData.append("cir", this.cir);
      formData.append("equipamento", this.equipamento);
      formData.append("observacao", this.observacao);
      formData.append("valor", this.valor);
      formData.append("valordecusto", this.valordecusto);
      formData.append("valormensal", this.valormensal);
      formData.append("velocmaxdown", this.velocmaxdown);
      formData.append("velocmaxup", this.velocmaxup);
      formData.append("velocmindown", this.velocmindown);
      formData.append("velocminup", this.velocminup);

      /* Recebendo um "objeto literal":
                                 Um objeto literal é composto por um par de chaves " { } ",
                                 que envolve uma ou mais propriedades. Cada propriedade segue
                                 o formato " nome: valor " e devem ser separadas por vírgula. */
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
