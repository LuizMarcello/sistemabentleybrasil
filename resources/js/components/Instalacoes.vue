<template>
  <!-- Aqui, como veio do blade, tem que tirar toda codificação PHP -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!--Inicio do card de busca  -->
        <card-component titulo="Busca de instalação">
          <template v-slot:conteudo>
            <div class="form-row">
              <div class="col mb-3">
                <input-container-component
                  titulo="ID"
                  id="inputId"
                  id-help="idHelp"
                  texto-ajuda=" Opcional. Informe o ID da instalação"
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
                  titulo="Cidade da instalação"
                  id="inputCidade"
                  id-help="cidadeHelp"
                  texto-ajuda=" Opcional. Informe a cidade da instalacao"
                >
                  <input
                    type="text"
                    class="form-control"
                    id="inputCidade"
                    aria-describedby="cidadeHelp"
                    placeholder="Cidade da instalação"
                    v-model="busca.cidade"
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

        <!-- Inicio do card de listagem de instalacões -->
        <card-component titulo="Relação de instalacões">
          <template v-slot:conteudo>
            <!-- Instanciando o componente Table.vue -->
            <table-component
              :dados="instalacaos.data"
              :visualizar="true"
              :atualizar="true"
              :remover="true"
              :titulos="{
                //id: { titulo: 'Id', tipo: 'texto' },
                //imagem: { titulo: 'Imagem', tipo: 'imagem' },
                //cliente_id: { titulo: 'Cliente', tipo: 'texto' },
                //rua: { titulo: 'Rua', tipo: 'texto' },
                //numero: { titulo: 'Número', tipo: 'texto' },
                //bairro: { titulo: 'Bairro', tipo: 'texto' },
                cidade: { titulo: 'Cidade', tipo: 'texto' },
                estado: { titulo: 'Estado', tipo: 'texto' },
                //celular: { titulo: 'Celular', tipo: 'texto' },
                //telefone: { titulo: 'Telefone', tipo: 'texto' },
                //status: { titulo: 'Status', tipo: 'texto' },
                banda: { titulo: 'Banda', tipo: 'texto' },
                //instalador_id: { titulo: 'Instalador', tipo: 'texto' },
                //distribuidor_id: { titulo: 'Distribuidor', tipo: 'texto' },
                plano_id: { titulo: 'Plano', tipo: 'texto' },
                //dataInstalacao: { titulo: 'Data da instalação', tipo: 'texto' },
                //observacao: { titulo: 'Observação', tipo: 'texto' },
                //notaFiscal: { titulo: 'Nota fiscal', tipo: 'texto' },
                //dataDaNota: { titulo: 'Data da nota', tipo: 'texto' },
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
                    v-for="(l, key) in instalacaos.links"
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
                  data-target="#modalInstalacao"
                >
                  Adicionar
                </button>
              </div>
            </div>
          </template>
        </card-component>
        <!-- Fim do card de listagem de instalações -->
      </div>
    </div>

    <!-- Aqui é feito a instância do componente/modal "Modal.vue" -->
    <modal-component id="modalInstalacao" titulo="Adicionar instalação">
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
          titulo="Erro ao tentar cadastrar a instalacao"
          v-if="transacaoStatus == 'erro'"
        ></alert-component>
      </template>

      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component
            titulo=""
            id="Instalacao"
            id-help="InstalacaoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="Instalacao"
              aria-describedby="instalacaoHelp"
              placeholder="Nome da instalação"
              v-model="instalacaos"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="cliente_id"
            id-help="cliente_idHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cliente_id"
              aria-describedby="cliente_idHelp"
              placeholder="Cliente"
              v-model="cliente_id"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component titulo="" id="rua" id-help="ruaHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="rua"
              aria-describedby="ruaHelp"
              placeholder="Rua"
              v-model="rua"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="numero"
            id-help="numeroHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="numero"
              aria-describedby="numeroHelp"
              placeholder="Número"
              v-model="numero"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="bairro"
            id-help="bairroHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="bairro"
              aria-describedby="bairroHelp"
              placeholder="Bairro"
              v-model="bairro"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="cidade"
            id-help="cidadeHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cidade"
              aria-describedby="cidadeHelp"
              placeholder="Cidade"
              v-model="cidade"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="estado"
            id-help="estadoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="estado"
              aria-describedby="estadoHelp"
              placeholder="Estado"
              v-model="estado"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="celular"
            id-help="celularHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="celular"
              aria-describedby="celularHelp"
              placeholder="Celular"
              v-model="celular"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="telefone"
            id-help="telefoneHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="telefone"
              aria-describedby="telefoneHelp"
              placeholder="Telefone"
              v-model="telefone"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="status"
            id-help="statusHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="status"
              aria-describedby="statusHelp"
              placeholder="Status"
              v-model="status"
            />
          </input-container-component>
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
          <input-container-component titulo="" id="" id-help="Help" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="instalador_id"
              aria-describedby="Help"
              placeholder="Instalador"
              v-model="instalador_id"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="distribuidor_id"
            id-help="distribuidor_idHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="distribuidor_id"
              aria-describedby="distribuidor_idHelp"
              placeholder="Distribuidor"
              v-model="distribuidor_id"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="plano_id"
            id-help="plano_idHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="plano_id"
              aria-describedby="plano_idHelp"
              placeholder="Plano"
              v-model="plano_id"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="dataInstalacao"
            id-help="dataInstalacaoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="date"
              class="form-control"
              id="dataInstalacao"
              aria-describedby="dataInstalacaoHelp"
              placeholder="Data Instalação"
              v-model="dataInstalacao"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="observacao"
            id-help="observacaoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="observacao"
              aria-describedby="observacaoHelp"
              placeholder="Observação"
              v-model="observacao"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="notaFiscal"
            id-help="notaFiscalHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="notaFiscal"
              aria-describedby="notaFiscalHelp"
              placeholder="Nota Fiscal"
              v-model="notaFiscal"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="dataDaNota"
            id-help="dataDaNotaHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="date"
              class="form-control"
              id="dataDaNota"
              aria-describedby="dataDaNotaHelp"
              placeholder="Data da Nota"
              v-model="dataDaNota"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo="Imagem"
            id="novaImagem"
            id-help="novaImagemHelp"
            texto-ajuda=" Carregue uma imagem no formato PNG"
          >
            <!-- Diretiva v-on(@) para evento "change(alteração)" -->
            <input
              type="file"
              class="form-control-file"
              id="novaImagem"
              aria-describedby="novaImagemHelp"
              placeholder="Selecione uma imagem"
              @change="carregarImagem($event)"
            />
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
      urlBase: "http://localhost:8000/api/v1/instalacoes",
      urlPaginacao: "",
      urlFiltro: "",
      cliente_id: "",
      rua: "",
      numero: "",
      bairro: "",
      cidade: "",
      estado: "",
      celular: "",
      telefone: "",
      status: "",
      banda: "",
      instalador_id: "",
      distribuidor_id: "",
      plano_id: "",
      dataInstalacao: "",
      observacao: "",
      notaFiscal: "",
      dataDaNota: "",
      arquivoImagem: [],
      transacaoStatus: "",
      transacaoDetalhes: {},
      instalacaos: { data: [] },
      busca: { id: "", cidade: "" },
    };
  },

  methods: {
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
          this.instalacaos = response.data;

          console.log(this.instalacaos);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    carregarImagem(e) {
      this.arquivoImagem = e.target.files;
    },
    salvar() {
      console.log(this.instalacaos, this.arquivoImagem[0]);

      /* Objeto formData: Instanciando um formulário para definir seus atributos */
      let formData = new FormData();
      /* Agora atribuindo valores ao formulário */
      formData.append("nome", this.nomeInstalacao);
      formData.append("imagem", this.arquivoImagem[0]);
      formData.append("cliente_id", this.cliente_id);
      formData.append("rua", this.rua);
      formData.append("numero", this.numero);
      formData.append("bairro", this.bairro);
      formData.append("cidade", this.cidade);
      formData.append("estado", this.estado);
      formData.append("celular", this.celular);
      formData.append("telefone", this.telefone);
      formData.append("status", this.status);
      formData.append("banda", this.banda);
      formData.append("instalador_id", this.instalador_id);
      formData.append("distribuidor_id", this.distribuidor_id);
      formData.append("plano_id", this.plano_id);
      formData.append("dataInstalacao", this.dataInstalacao);
      formData.append("observacao", this.observacao);
      formData.append("notaFiscal", this.notaFiscal);
      formData.append("dataDaNota", this.dataDaNota);

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
