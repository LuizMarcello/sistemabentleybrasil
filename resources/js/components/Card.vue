<template>

  <div class="card mb-4">
    <div class="card-header">{{ titulo }}</div>

    <div class="card-body">
      <!-- Tag "slot": Imprime o conteúdo interno passado pela
             instância do componente -->
      <slot name="conteudo"></slot>
    </div>

    <div class="card-footer">
      <!-- Tag "slot": Imprime o conteúdo interno passado pela
             instância do componente -->
      <slot name="rodape"></slot>
    </div>

  </div>

</template>

<script>
export default {
  props: ["titulo"],
};
</script>

<style>
</style>
