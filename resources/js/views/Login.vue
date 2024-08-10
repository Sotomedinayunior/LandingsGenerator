<template>
    <section class="container-login">
      <div class="column-login">
        <img src="../static/asset/Logo.webp" alt="Logo nelly" width="255" loading="lazy" />
        <FormComponent />
      </div>
      <div class="column-image"></div>
    </section>
  </template>
  
  <script>
  import FormComponent from '../components/FormLogin.vue';
  
  export default {
    components: { FormComponent }
  };
  </script>
  
  <style scoped lang="scss">
  .container-login {
    display: grid;
    height: 100vh;
    grid-template-columns: 50% 50%;
    justify-content: center;
    align-items: center;
  }
  
  .column-login {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
  
  .column-image {
    background-image: url('../static/asset/front_cart.webp');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    height: 100vh;
  }
  </style>
  