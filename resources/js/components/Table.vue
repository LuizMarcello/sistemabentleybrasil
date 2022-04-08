<template>
  <div>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col" v-for="(t, key) in titulos" :key="key">
            {{ t.titulo }}
          </th>
        </tr>
      </thead>
      <tbody>
        <!-- v-for recuperando cada um dos objetos deste array de objeto-->
        <tr v-for="(obj, chave) in dadosFiltrados" :key="chave">
          <td></td>
        </tr>
        <!-- Varrendo todos os objetos em "dados" -->
        <!-- <tr v-for="obj in dados" :key="obj.id"> -->
        <!-- Varrendo cada "chave e valores" em cada objeto -->
        <!-- Renderização condicional, somente quando includes()
               tiver um dos itens do array igual a "chave" -->
        <!-- <td v-if="titulos.includes(chave)" v-for="(valor, chave) in obj" :key="chave"> -->
        <!-- Renderização condicional -->
        <!--  <span v-if="chave == 'imagem'">
              <img :src="'/storage/' + valor" width="36" height="36" />
            </span>
            <span v-else>
              {{ valor }}
            </span>
          </td> -->

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
  computed: {
    dadosFiltrados() {
      console.log("chegamos até aqui");
      return ""; //Retornará um array de objetos
    },
  },
};
</script>

<style></style>
