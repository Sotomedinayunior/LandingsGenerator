<template>
  <section>
    <NavDesigner />

    <router-view></router-view>

   </section>
</template>

<script>
import NavDesigner from './NavDesigner.vue';

NavDesigner
export default {
  components: {
    NavDesigner
  },
  
  data() {
    return {
   
    };
  },
 
  
};
</script>

<style scoped>
button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}
</style>
