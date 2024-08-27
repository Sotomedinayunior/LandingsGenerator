<template>
  <div>
    <!-- Botón que redirige a la ruta 'LayoutDesigner' -->
    <a href="javascript:void(0);" @click="navigateToLayoutDesigner" class="btn-new">+ Crear Nuevo Landing</a>
  </div>
</template>

<script>
export default {
  methods: {
    navigateToLayoutDesigner() {
      this.$router.push('/layout-designer');
    }
  }
};
</script>

<style  lang="scss">
.btn-new {
  background-color: $color-background-secondary;
  font-size: clamp(12px, 1vw, 1.5rem);
  border-radius: 8px;
  padding: 14px 25px;
  color: $color-font-tertiary;
}
</style>
