<template>
  <div class="form-group">
    <label :for="id" class="form-label">{{ titulo }}</label>
    <!-- Tag "slot": Imprime o conteúdo interno passado pelo componente
         (Antenas.vue, entre a tag de abertura e fechamento), os "<input>"
         no caso -->
    <slot></slot>
    <div :id="idHelp" class="form-text text-muted">
      {{ textoAjuda }}
    </div>
  </div>
</template>


<script>
export default {
  props: ["id", "titulo", "idHelp", "textoAjuda"],
};
</script>


<style>
</style>
