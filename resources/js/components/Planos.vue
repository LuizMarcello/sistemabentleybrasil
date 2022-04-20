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
                  />
                </input-container-component>
              </div>
            </div>
          </template>

          <template v-slot:rodape>
            <button type="Submit" class="btn btn-primary btn-sm float-right">
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
              :dados="planos"
              :titulos="{
                id: { titulo: 'Id', tipo: 'texto' },
                nome: { titulo: 'Nome', tipo: 'texto' },
                imagem: { titulo: 'Imagem', tipo: 'imagem' },
                created_at: { titulo: 'Criação', tipo: 'data' },
                //updated_at: { titulo: 'Data da atualização', tipo: 'data' },
              }"
            ></table-component>
          </template>

          <template v-slot:rodape>
            <button
              type="button"
              class="btn btn-primary btn-sm float-right"
              data-toggle="modal"
              data-target="#modalPlano"
            >
              Adicionar
            </button>
          </template>
        </card-component>
        <!-- Fim do card de listagem de planos -->
      </div>
    </div>

    <!-- Aqui é feito a instância do componente/modal "Modal.vue" -->
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
            titulo="Nome do plano"
            id="novoPlano"
            id-help="novoPlanoHelp"
            texto-ajuda=" Informe o nome do plano"
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
          <!-- {{ arquivoImagem }} -->
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
      urlBase: "http://localhost:8000/api/v1/planos",
      nomeAntena: "",
      arquivoImagem: [],
      transacaoStatus: "",
      transacaoDetalhes: {},
      planos: [],
    };
  },

  methods: {
    carregarLista() {
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
        .get(this.urlBase, config)
        .then((response) => {
          this.planos = response.data;

          console.log(this.planos)
        })
        .catch((errors) => {
          console.log(errors);
        });
    },



    carregarImagem(e) {
      this.arquivoImagem = e.target.files;
    },
    salvar() {
      console.log(this.nomePlano, this.arquivoImagem[0]);

      /* Objeto formData: Instanciando um formulário para definir seus atributos */
      let formData = new FormData();
      /* Agora atribuindo valores ao formulário */
      formData.append("nome", this.nomePlano);
      formData.append("imagem", this.arquivoImagem[0]);

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
