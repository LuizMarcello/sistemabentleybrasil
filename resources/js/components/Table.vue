<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{ t }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="a in dados" :key="a.id">
                    <!-- Usando o double mustache -->
                    <th scope="row">{{ a.id }}</th>
                    <td>{{ a.nome }}</td>
                    <td>{{ a.marca }}</td>
                    <td>
                        <img :src="'/storage/' + a.imagem" width="33" height="33" />
                    </td>
                </tr>
            </tbody>
        </table>
        <!--  {{ dados }} -->
    </div>
</template>

<script>
export default {
    props: ['dados', 'titulos']
};
</script>

<style>
</style>
