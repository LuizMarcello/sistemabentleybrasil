<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="(t, key) in titulos" :key="key">{{ t.titulo }}</th>
                </tr>
            </thead>
            <tbody>
                <!-- v-for recuperando cada um dos objetos deste array de objeto-->
                <tr v-for="(obj, chave) in dadosFiltrados" :key="chave">
                    <!-- <td>{{ obj }}</td> -->
                </tr>
                <!-- Varrendo todos os objetos em "dados" -->
                <!-- <tr v-for="obj in dados" :key="obj.id"> -->
                <!-- Varrendo cada "chave e valores" em cada objeto -->
                <!-- Renderização condicional, somente quando includes()
                tiver um dos itens do array igual a "chave"-->
                <!-- <td v-if="titulos.includes(chave)" v-for="(valor, chave) in obj" :key="chave"> -->
                <!-- Renderização condicional -->
                <!--  <span v-if="chave == 'imagem'">
              <img :src="'/storage/' + valor" width="36" height="36" />
            </span>
            <span v-else>
              {{ valor }}
            </span>
                </td>-->

                <!-- Usando o double mustache -->
                <!--
                    <th scope="row">{{ a.id }}</th>
                    <td>{{ a.nome }}</td>
                    <td>{{ a.marca }}</td>
                    <td>
                        <img :src="'/storage/' + a.imagem" width="36" height="36" />
                    </td>
                -->
                <!--  </tr> -->
            </tbody>
        </table>
        <!--  {{ dados }} -->
    </div>
</template>

<script>
export default {
    props: ["dados", "titulos"],
    /* Proprieades computadas */
    computed: {
        dadosFiltrados() {
            /* Recuperando todas as chaves deste objeto "titulos" */
            let campos = Object.keys(this.titulos)
            let dadosFiltradosss = []
            //console.log(campos)
            //console.log(this.titulos)
            //console.log("chegamos até aqui");
            //console.log(this.dados)

            /* Recuperando isoladamente a chave e item de cada um dos objetos */
            this.dados.map((item, chave) => {
                //console.log(chave, item)

                let itemFiltrado = {}

                /* Fazendo um laço e percorrendo todos os itens de campos */
                campos.forEach(campo => {
                    //console.log(campo)

                    //Javascript:
                    //Utilizando a sintaxe de array para atribuir valores a objetos
                    itemFiltrado[campo] = item[campo]

                    //console.log(chave, item, campo)
                    //console.log(itemFiltrado)
                })

                dadosFiltradosss.push(itemFiltrado)
            })

            console.log(dadosFiltradosss)

            return ""; //Retornará um array de objetos
        },
    },
};
</script>

<style></style>
