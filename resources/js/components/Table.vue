<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="(t, key) in titulos" :key="key">{{ t.titulo }}</th>
                    <!-- if(): Renderização condicional -->
                    <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
                </tr>
            </thead>
            <tbody>
                <!-- Laço v-for recuperando cada um dos objetos deste array de objeto-->
                <!-- Para chamar um método computado, não precisa abre e fecha chaves -->
                <!-- São considerados mesmo como propriedades computadas -->
                <tr v-for="(obj, chave) in dadosFiltrrados" :key="chave">
                    <!-- Laço v-for recuperando cada um dos atributos de cada objeto -->
                    <td v-for="(valor, chaveValor) in obj" :key="chaveValor">
                        <!-- v-if: renderização condicional -->
                        <!-- Usando o double mustache -->
                        <span v-if="titulos[chaveValor].tipo == 'texto'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ valor | formataDataTempoGlobal }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/' + valor" width="36" height="36" />
                        </span>
                    </td>
                    <!-- if(): Renderização condicional -->
                    <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                        <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm"
                            :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget"
                            @click="setStore(obj)">
                            Visualizar
                        </button>

                        <button v-if="atualizar.visivel" class="btn btn-outline-primary btn-sm"
                            :data-toggle="atualizar.dataToggle" :data-target="atualizar.dataTarget"
                            @click="setStore(obj)">
                            Atualizar
                        </button>

                        <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm"
                            :data-toggle="remover.dataToggle" :data-target="remover.dataTarget" @click="setStore(obj)">
                            Remover
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
/* Aqui é o objeto literal de instância deste componente */
export default {
    /* Atributo "filters", com objeto literal com os
       métodos que farão a aplicação dos filtros,
       em modo local, para este componente */
    filters: {

    },
    props: ["dados", "titulos", "atualizar", "visualizar", "remover"],
    methods: {
        setStore(obj) {
            this.$store.state.transacao.status = "";
            this.$store.state.transacao.mensagem = "";
            this.$store.state.transacao.dados = "";
            this.$store.state.item = obj;
        },
    },
    /* Propriedades computadas */
    computed: {
        dadosFiltrrados() {
            //console.log(this.dados);
            /* Recuperando todas as chaves deste objeto "titulos" */
            let campos = Object.keys(this.titulos);
            let dadosFiltradosss = [];
            /* Recuperando isoladamente a chave e item de cada um dos objetos */
            this.dados.map((item, chave) => {
                let itemFiltrado = {};
                /* Fazendo um laço e percorrendo todos os itens de campos */
                campos.forEach((campo) => {
                    //Javascript:
                    //Utilizando a sintaxe de array para atribuir valores a objetos
                    itemFiltrado[campo] = item[campo];
                });
                dadosFiltradosss.push(itemFiltrado);
            });
            /*  Retornará um array de objetos */
            return dadosFiltradosss;
        },
    },
};
</script>

<style>
</style>
