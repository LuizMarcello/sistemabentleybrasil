<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="(t, key) in titulos" :key="key">{{ t.titulo }}</th>
                </tr>
            </thead>
            <tbody>
                <!-- Laço v-for recuperando cada um dos objetos deste array de objeto-->
                <!-- Para chamar um método computado, não precisa abre e fecha chaves -->
                <!-- São considerados mesmo como propriedades computadas -->
                <tr v-for="(obj, chave) in dadosFiltrrados" :key="chave">
                    <!-- Laço v-for recuperando cada um dos atributos dos objetos -->
                    <td v-for="(valor, chaveValor) in obj" :key="chaveValor">
                        <!-- v-if: renderização condicional -->
                        <!-- Usando o double mustache -->
                        <span v-if="titulos[chaveValor].tipo == 'texto'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ '...' + valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/' + valor" width="36" height="36" />
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ["dados", "titulos"],
    /* Proprieades computadas */
    computed: {
        dadosFiltrrados() {

            console.log(this.dados)

            /* Recuperando todas as chaves deste objeto "titulos" */
            let campos = Object.keys(this.titulos)
            let dadosFiltradosss = []

            /* Recuperando isoladamente a chave e item de cada um dos objetos */
            this.dados.map((item, chave) => {

                let itemFiltrado = {}

                /* Fazendo um laço e percorrendo todos os itens de campos */
                campos.forEach(campo => {

                    //Javascript:
                    //Utilizando a sintaxe de array para atribuir valores a objetos
                    itemFiltrado[campo] = item[campo]
                })

                dadosFiltradosss.push(itemFiltrado)
            })

            return dadosFiltradosss; //Retornará um array de objetos
        },
    },
};
</script>

<style></style>
