<template>
  <!-- Aqui, como veio do blade, tem que tirar toda codificação PHP -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!--Inicio do card de busca  -->
        <card-component titulo="Busca de cliente">
          <template v-slot:conteudo>
            <div class="form-row">
              <div class="col mb-3">
                <input-container-component
                  titulo="ID"
                  id="inputId"
                  id-help="idHelp"
                  texto-ajuda=" Opcional. Informe o ID do cliente"
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
                  titulo="Nome do cliente"
                  id="inputNome"
                  id-help="nomeHelp"
                  texto-ajuda=" Opcional. Informe o nome do cliente"
                >
                  <input
                    type="text"
                    class="form-control"
                    id="inputNome"
                    aria-describedby="nomeHelp"
                    placeholder="Nome do cliente"
                    v-model="busca.nome_razaosocial"
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

        <!-- Inicio do card de listagem de clientes -->
        <card-component titulo="Relação de clientes">
          <template v-slot:conteudo>
            <!-- Instanciando o componente Table.vue -->
            <table-component
              :dados="clientes.data"
              :visualizar="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalClienteVisualizar',
              }"
              :atualizar="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalClienteAtualizar',
              }"
              :remover="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalClienteRemover',
              }"
              :titulos="{
                id: { titulo: 'Id', tipo: 'texto' },
                nome_razaosocial: { titulo: 'Nome RazaoSocial', tipo: 'texto' },
                //imagem: { titulo: 'Imagem', tipo: 'imagem' },
                //cpf: { titulo: 'Cpf', tipo: 'texto' },
                //ie_rg: { titulo: 'Ie ou Rg', tipo: 'texto' },
                //nome_contato: { titulo: 'Nome do Contato', tipo: 'texto' },
                //celular: { titulo: 'Celular', tipo: 'texto' },
                //telefone: { titulo: 'Telefone', tipo: 'texto' },
                //email: { titulo: 'Email', tipo: 'texto' },
                //chave: { titulo: 'Chave', tipo: 'texto' },
                //dataadesao: { titulo: 'Data Adesao', tipo: 'data' },
                //observacao: { titulo: 'Observação', tipo: 'texto' },
                //cep: { titulo: 'cep', tipo: 'texto' },
                //rua: { titulo: 'Rua', tipo: 'texto' },
                //numero: { titulo: 'Número', tipo: 'texto' },
                //bairro: { titulo: 'bairro', tipo: 'texto' },
                cidade: { titulo: 'Cidade', tipo: 'texto' },
                estado: { titulo: 'Estado', tipo: 'texto' },
                //situacao: { titulo: 'Situação', tipo: 'texto' },
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
                    v-for="(l, key) in clientes.links"
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
                  data-target="#modalCliente"
                >
                  Adicionar
                </button>
              </div>
            </div>
          </template>
        </card-component>
        <!-- Fim do card de listagem de clientes -->
      </div>
    </div>

    <!-- Aqui é feito a instância do componente/modal "Modal.vue", para inclusão -->
    <!-- Inicio do modal de "inclusão"  -->
    <modal-component id="modalCliente" titulo="Adicionar cliente">
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
          titulo="Erro ao tentar cadastrar o cliente"
          v-if="transacaoStatus == 'erro'"
        ></alert-component>
      </template>

      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component
            titulo=""
            id="novoCliente"
            id-help="novoClienteHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="novoCliente"
              aria-describedby="novoClienteHelp"
              placeholder="Nome"
              v-model="nome_razaosocial"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component titulo="" id="cpf" id-help="cpfHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cpf"
              aria-describedby="cpfHelp"
              placeholder="CPF"
              v-model="cpf"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="ie_rg"
            id-help="ie_rgHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="ie_rg"
              aria-describedby="ie_rgHelp"
              placeholder="IE ou RG"
              v-model="ie_rg"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="nome_contato"
            id-help="nome_contatoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="nome_contato"
              aria-describedby="nome_contatoHelp"
              placeholder="Contato"
              v-model="nome_contato"
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
              placeholder="Telefone fixo"
              v-model="telefone"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="email"
            id-help="emailHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="email"
              aria-describedby="emailHelp"
              placeholder="Melhor email"
              v-model="email"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="chave"
            id-help="chaveHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="chave"
              aria-describedby="chaveHelp"
              placeholder="Chave"
              v-model="chave"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="dataadesao"
            id-help="dataadesaoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="date"
              class="form-control"
              id="dataadesao"
              aria-describedby="dataadesaoHelp"
              placeholder="Data da adesao"
              v-model="dataadesao"
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
              placeholder="Observacao"
              v-model="observacao"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component titulo="" id="cep" id-help="cepHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cep"
              aria-describedby="cepHelp"
              placeholder="Cep"
              v-model="cep"
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
            id="situacao"
            id-help="situacaoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="situacao"
              aria-describedby="situacaoHelp"
              placeholder="Situacao"
              v-model="situacao"
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
    <modal-component id="modalClienteRemover" titulo="Remover cliente">
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

        <input-container-component titulo="Nome do cliente">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.nome"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Cidade">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.cidade"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Estado">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.estado"
            disabled
          />
        </input-container-component>
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
    <modal-component id="modalClienteVisualizar" titulo="Visualizar cliente">
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

        <input-container-component titulo="Nome/Razão social">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.nome_razaosocial"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="CPF">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.cpf"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="RG">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.ie_rg"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Contato">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.nome_contato"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Celular">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.celular"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Telefone">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.telefone"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Email">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.email"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Chave">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.chave"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Data adesão">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.dataadesao"
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

        <input-container-component titulo="CEP">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.cep"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Rua">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.rua"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Número">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.numero"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Bairro">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.bairro"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Cidade">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.cidade"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Estado">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.estado"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Situação">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.situacao"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Imagem">
          <img
            :src="'storage/' + $store.state.item.imagem"
            v-if="$store.state.item.imagem"
          />
        </input-container-component>

        <input-container-component titulo="Data criação">
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
        <button type=" button" class="btn btn-secondary" data-dismiss="modal">
          Fechar
        </button>
      </template>
    </modal-component>
    <!-- Fim do modal de visualização(detalhes) -->

    <!-- Aqui é feito a instância do componente/modal "Modal.vue", para atualização -->
    <!-- Inicio do modal de "atualização"  -->
    <modal-component id="modalClienteAtualizar" titulo="Atualizar cliente">
      <template v-slot:alertas> </template>

      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component
            titulo=""
            id="novoCliente"
            id-help="novoClienteHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="novoCliente"
              aria-describedby="novoClienteHelp"
              placeholder="Nome"
              v-model="$store.state.item.nome_razaosocial"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component titulo="" id="cpf" id-help="cpfHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cpf"
              aria-describedby="cpfHelp"
              placeholder="CPF"
              v-model="$store.state.item.cpf"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="ie_rg"
            id-help="ie_rgHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="ie_rg"
              aria-describedby="ie_rgHelp"
              placeholder="IE ou RG"
              v-model="$store.state.item.ie_rg"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="nome_contato"
            id-help="nome_contatoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="nome_contato"
              aria-describedby="nome_contatoHelp"
              placeholder="Contato"
              v-model="$store.state.item.nome_contato"
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
              v-model="$store.state.item.celular"
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
              placeholder="Telefone fixo"
              v-model="$store.state.item.telefone"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="email"
            id-help="emailHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="email"
              aria-describedby="emailHelp"
              placeholder="Melhor email"
              v-model="$store.state.item.email"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="chave"
            id-help="chaveHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="chave"
              aria-describedby="chaveHelp"
              placeholder="Chave"
              v-model="$store.state.item.chave"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="dataadesao"
            id-help="dataadesaoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="date"
              class="form-control"
              id="dataadesao"
              aria-describedby="dataadesaoHelp"
              placeholder="Data da adesao"
              v-model="$store.state.item.dataadesao"
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
              placeholder="Observacao"
              v-model="$store.state.item.observacao"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component titulo="" id="cep" id-help="cepHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cep"
              aria-describedby="cepHelp"
              placeholder="Cep"
              v-model="$store.state.item.cep"
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
              v-model="$store.state.item.rua"
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
              v-model="$store.state.item.numero"
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
              v-model="$store.state.item.bairro"
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
              v-model="$store.state.item.cidade"
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
              v-model="$store.state.item.estado"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="situacao"
            id-help="situacaoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="situacao"
              aria-describedby="situacaoHelp"
              placeholder="Situacao"
              v-model="$store.state.item.situacao"
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
      urlBase: "http://localhost:8000/api/v1/clientes",
      urlPaginacao: "",
      urlFiltro: "",
      nome_razaosocial: "",
      cpf: "",
      ie_rg: "",
      nome_contato: "",
      celular: "",
      telefone: "",
      email: "",
      chave: "",
      dataadesao: "",
      observacao: "",
      cep: "",
      rua: "",
      numero: "",
      bairro: "",
      cidade: "",
      estado: "",
      situacao: "",
      arquivoImagem: [],
      transacaoStatus: "",
      transacaoDetalhes: {},
      clientes: { data: [] },
      busca: { id: "", nome_razaosocial: "" },
    };
  },

  methods: {
    atualizar() {
      /* Criando um formulário programático, para uma requisição http */
      let formData = new FormData();
      formData.append("_method", "patch");
      formData.append("nome_razaosocial", this.$store.state.item.nome_razaosocial);

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
          atualizarImagem.value = "";
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
          this.clientes = response.data;

          console.log(this.clientes);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    carregarImagem(e) {
      this.arquivoImagem = e.target.files;
    },
    salvar() {
      console.log(this.nome_razaosocial, this.arquivoImagem[0]);

      /* Objeto formData: Instanciando um formulário para definir seus atributos */
      let formData = new FormData();
      /* Agora atribuindo valores ao formulário */
      formData.append("nome_razaosocial", this.nome_razaosocial);
      formData.append("imagem", this.arquivoImagem[0]);
      formData.append("cpf", this.cpf);
      formData.append("ie_rg", this.ie_rg);
      formData.append("nome_contato", this.nome_contato);
      formData.append("celular", this.celular);
      formData.append("telefone", this.telefone);
      formData.append("email", this.email);
      formData.append("chave", this.chave);
      formData.append("dataadesao", this.dataadesao);
      formData.append("observacao", this.observacao);
      formData.append("cep", this.cep);
      formData.append("rua", this.rua);
      formData.append("numero", this.numero);
      formData.append("bairro", this.bairro);
      formData.append("cidade", this.cidade);
      formData.append("estado", this.estado);
      formData.append("situacao", this.situacao);

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
