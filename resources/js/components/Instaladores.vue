<template>
  <!-- Aqui, como veio do blade, tem que tirar toda codificação PHP -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!--Inicio do card de busca  -->
        <card-component titulo="Busca de instaladores">
          <template v-slot:conteudo>
            <div class="form-row">
              <div class="col mb-3">
                <input-container-component
                  titulo="ID"
                  id="inputId"
                  id-help="idHelp"
                  texto-ajuda=" Opcional. Informe o ID do instalador"
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
                  titulo="Nome do instalador"
                  id="inputNome"
                  id-help="nomeHelp"
                  texto-ajuda=" Opcional. Informe o nome do instalador"
                >
                  <input
                    type="text"
                    class="form-control"
                    id="inputNome"
                    aria-describedby="nomeHelp"
                    placeholder="Nome do instalador"
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

        <!-- Inicio do card de listagem de instaladores -->
        <card-component titulo="Relação de instaladores">
          <template v-slot:conteudo>
            <!-- Instanciando o componente Table.vue -->
            <table-component
              :dados="instaladores.data"
              :visualizar="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalInstaladorVisualizar',
              }"
              :atualizar="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalInstaladorAtualizar',
              }"
              :remover="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalInstaladorRemover',
              }"
              :titulos="{
                id: { titulo: 'Id', tipo: 'texto' },
                nome: { titulo: 'Nome', tipo: 'texto' },
                //imagem: { titulo: 'Imagem', tipo: 'imagem' },
                //bairro: { titulo: 'Bairro', tipo: 'texto' },
                //celular: { titulo: 'Celular', tipo: 'texto' },
                //cep: { titulo: 'Cep', tipo: 'texto' },
                cidade: { titulo: 'Cidade', tipo: 'texto' },
                //cpf: { titulo: 'Cpf', tipo: 'texto' },
                //dataNascimento: { titulo: 'Data Nascimento', tipo: 'data' },
                //email: { titulo: 'Email', tipo: 'texto' },
                estado: { titulo: 'Estado', tipo: 'texto' },
                //numero: { titulo: 'Numero', tipo: 'texto' },
                //observacao: { titulo: 'Observações', tipo: 'texto' },
                //rg: { titulo: 'RG', tipo: 'texto' },
                //rua: { titulo: 'Rua', tipo: 'texto' },
                situacao: { titulo: 'Situação', tipo: 'texto' },
                //telefone: { titulo: 'Telefone', tipo: 'texto' },
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
                    v-for="(l, key) in instaladores.links"
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
                  data-target="#modalInstalador"
                >
                  Adicionar
                </button>
              </div>
            </div>
          </template>
        </card-component>
        <!-- Fim do card de listagem de instaladores -->
      </div>
    </div>

    <!-- Aqui é feito a instância do componente/modal "Modal.vue", para inclusão -->
    <!-- Inicio do modal de "inclusão"  -->
    <modal-component id="modalInstalador" titulo="Adicionar instalador">
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
          titulo="Erro ao tentar cadastrar a instalador"
          v-if="transacaoStatus == 'erro'"
        ></alert-component>
      </template>

      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component
            titulo=""
            id="novoInstalador"
            id-help="novoInstaladorHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="novoInstalador"
              aria-describedby="novoInstaladorHelp"
              placeholder="Nome do Instalador"
              v-model="nomeInstalador"
            />
          </input-container-component>
          <!-- {{ nome }} -->
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
          <input-container-component titulo="" id="cpf" id-help="cpfHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cpf"
              aria-describedby="cpfHelp"
              placeholder="Cpf"
              v-model="cpf"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="dataNascimento"
            id-help="dataNascimentoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="date"
              class="form-control"
              id="dataNascimento"
              aria-describedby="dataNascimentoHelp"
              placeholder="Data de Nascimento"
              v-model="dataNascimento"
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
              placeholder="Email"
              v-model="email"
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
              placeholder="Observacões"
              v-model="observacao"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component titulo="" id="rg" id-help="rgHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="rg"
              aria-describedby="rgHelp"
              placeholder="RG"
              v-model="rg"
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
    <!-- Fim do modal de inclusão -->

    <!-- Aqui é feito a instância do componente/modal "Modal.vue", para remoção -->
    <!-- Inicio do modal de remoção -->
    <modal-component id="modalInstaladorRemover" titulo="Remover instalador">
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

        <input-container-component titulo="Nome do instalador">
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
    <modal-component id="modalInstaladorVisualizar" titulo="Visualizar instalador">
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

        <input-container-component titulo="Bairro">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.bairro"
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

        <input-container-component titulo="CEP">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.cep"
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

        <input-container-component titulo="CPF">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.cpf"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Data de nascimento">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.dataNascimento"
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

        <input-container-component titulo="Estado">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.estado"
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

        <input-container-component titulo="Observação">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.observacao"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="RG">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.rg"
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

        <input-container-component titulo="Situação">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.situacao"
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

        <input-container-component titulo="Imagem">
          <img
            :src="'storage/' + $store.state.item.imagem"
            v-if="$store.state.item.imagem"
          />
        </input-container-component>

        <input-container-component titulo="Data da criação">
          <input
            type="text"
            class="form-control"
            :value="$store.state.item.created_at"
            disabled
          />
        </input-container-component>

        <input-container-component titulo="Ultima atualização">
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
    <modal-component id="modalInstaladorAtualizar" titulo="Atualizar instalador">
      <template v-slot:alertas>
        <alert-component
          tipo="success"
          titulo="Transação com sucesso"
          :detalhes="$store.state.transacao"
          v-if="$store.state.transacao.status == 'sucesso'"
        ></alert-component>
        <alert-component
          tipo="danger"
          titulo="Erro na transação"
          :detalhes="$store.state.transacao"
          v-if="$store.state.transacao.status == 'erro'"
        ></alert-component>
      </template>

      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component
            titulo=""
            id="novoInstalador"
            id-help="novoInstaladorHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="novoInstalador"
              aria-describedby="novoInstaladorHelp"
              placeholder="Nome do Instalador"
              v-model="$store.state.item.nome"
            />
          </input-container-component>
          <!-- {{ nome }} -->
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
          <input-container-component titulo="" id="cpf" id-help="cpfHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="cpf"
              aria-describedby="cpfHelp"
              placeholder="Cpf"
              v-model="$store.state.item.cpf"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo=""
            id="dataNascimento"
            id-help="dataNascimentoHelp"
            texto-ajuda=""
          >
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="date"
              class="form-control"
              id="dataNascimento"
              aria-describedby="dataNascimentoHelp"
              placeholder="Data de Nascimento"
              v-model="$store.state.item.dataNascimento"
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
              placeholder="Email"
              v-model="$store.state.item.email"
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
              placeholder="Observacões"
              v-model="$store.state.item.observacao"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component titulo="" id="rg" id-help="rgHelp" texto-ajuda="">
            <!-- v-model: sincroniza com two-way-data binding -->
            <input
              type="text"
              class="form-control"
              id="rg"
              aria-describedby="rgHelp"
              placeholder="RG"
              v-model="rg"
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
              v-model="$store.state.item.telefone"
            />
          </input-container-component>
        </div>

        <div class="form-group">
          <input-container-component
            titulo="Imagem"
            id="atualizarImagem"
            id-help="atualizarImagemHelp"
            texto-ajuda=" Carregue uma imagem no formato PNG"
          >
            <!-- Diretiva v-on(@) para evento "change(alteração)" -->
            <input
              type="file"
              class="form-control-file"
              id="atualizarImagem"
              aria-describedby="atualizarImagemHelp"
              placeholder="Selecione uma imagem"
              @change="carregarImagem($event)"
            />
          </input-container-component>
        </div>
        <!-- {{ $store.state.item }} -->
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
  computed: {},

  data() {
    return {
      urlBase: "http://localhost:8000/api/v1/instaladores",
      urlPaginacao: "",
      urlFiltro: "",
      id: "",
      nomeInstalador: "",
      bairro: "",
      celular: "",
      cep: "",
      cidade: "",
      cpf: "",
      dataNascimento: "",
      email: "",
      estado: "",
      instalacao_id: "",
      numero: "",
      observacao: "",
      rg: "",
      rua: "",
      situacao: "",
      telefone: "",
      arquivoImagem: [],
      transacaoStatus: "",
      transacaoDetalhes: {},
      instaladores: { data: [] },
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
          this.instaladores = response.data;

          console.log(this.instaladores);
        })
        .catch((errors) => {
          console.log(errors);
        });
    },

    carregarImagem(e) {
      this.arquivoImagem = e.target.files;
    },
    salvar() {
      console.log(this.nomeInstalador, this.arquivoImagem[0]);

      /* Objeto formData: Instanciando um formulário para definir seus atributos */
      let formData = new FormData();
      /* Agora atribuindo valores ao formulário */
      formData.append("nome", this.nomeInstalador);
      formData.append("imagem", this.arquivoImagem[0]);
      formData.append("bairro", this.bairro);
      formData.append("celular", this.celular);
      formData.append("cep", this.cep);
      formData.append("cidade", this.cidade);
      formData.append("cpf", this.cpf);
      formData.append("dataNascimento", this.dataNascimento);
      formData.append("email", this.email);
      formData.append("estado", this.estado);
      formData.append("instalacao_id", this.instalacao_id);
      formData.append("numero", this.numero);
      formData.append("observacao", this.observacao);
      formData.append("rg", this.rg);
      formData.append("rua", this.rua);
      formData.append("situacao", this.situacao);
      formData.append("telefone", this.telefone);

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
};
</script>
