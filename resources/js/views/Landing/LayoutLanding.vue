<template>
    <div>
      <header>
        <h1>{{ message }}</h1>
      
      </header>
      <main>
        <router-view></router-view>
      </main>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        message: 'Hola Mundo',
      };
    },
  };
  </script>
  
  <style scoped>
  h1 {
    color: blue;
  }
  </style>