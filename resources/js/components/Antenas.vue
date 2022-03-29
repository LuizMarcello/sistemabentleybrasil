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
                                <input-container-component
                                    titulo="ID"
                                    id="inputId"
                                    id-help="idHelp"
                                    texto-ajuda=" Opcional. Informe o ID da antena"
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
                                    titulo="Nome da antena"
                                    id="inputNome"
                                    id-help="nomeHelp"
                                    texto-ajuda=" Opcional. Informe o nome da antena"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inputNome"
                                        aria-describedby="nomeHelp"
                                        placeholder="Nome da antena"
                                    />
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button
                            type="Submit"
                            class="btn btn-primary btn-sm float-right"
                        >
                            Pesquisar
                        </button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->

                <!-- Inicio do card de listagem de antenas -->
                <card-component titulo="Relação de antenas">
                    <template v-slot:conteudo>
                        <!-- Instanciando o componente Table.vue -->
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button
                            type="button"
                            class="btn btn-primary btn-sm float-right"
                            data-toggle="modal"
                            data-target="#modalAntena"
                        >
                            Adicionar
                        </button>
                    </template>
                </card-component>
                <!-- Fim do card de listagem de antenas -->
            </div>
        </div>

        <!-- Aqui é feito a instância do componente/modal "Modal.vue" -->
        <modal-component id="modalAntena" titulo="Adicionar antena">
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component
                        titulo="Nome da antena"
                        id="novaAntena"
                        id-help="novaAntenaHelp"
                        texto-ajuda=" Informe o nome da antena"
                    >
                        <!-- v-model: sincroniza com two-way-data binding -->
                        <input
                            type="text"
                            class="form-control"
                            id="novaAntena"
                            aria-describedby="novaAntenaHelp"
                            placeholder="Nome da antena"
                            v-model="nomeAntena"
                        />
                    </input-container-component>
                    {{ nomeAntena }}
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
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    Fechar
                </button>
                <!-- Diretiva v-on(@) para evento "click(acionar)" -->
                <button type="button" class="btn btn-primary" @click="salvar()">
                    Salvar
                </button>
            </template>
        </modal-component>
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

            console.log(token);

            return "Teste";
        },
    },
    data() {
        return {
            urlBase: "http://localhost:8000/api/v1/antenas",
            nomeAntena: "",
            arquivoImagem: [],
        };
    },
    methods: {
        carregarImagem(e) {
            this.arquivoImagem = e.target.files;
        },
        salvar() {
            console.log(this.nomeAntena, this.arquivoImagem[0]);

            /* Objeto formData: Instanciando um formulário para definir seus atributos */
            let formData = new FormData();
            /* Agora atribuindo valores ao formulário */
            formData.append("nome", this.nomeAntena);
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
               projetos front-end no framework laravel */
            /* Este método (post()) espera 03 parâmetros: */
            axios
                .post(this.urlBase, formData, config)
                /* Pegando(recuperando) a resposta */
                .then((response) => {
                    console.log(response);
                })
                /* Se houver êrro */
                .catch((errors) => {
                    console.log(errors);
                });
        },
    },
};
</script>
