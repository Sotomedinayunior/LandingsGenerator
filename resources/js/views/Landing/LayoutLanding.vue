<template>
    <div>
      <div>
        <router-view></router-view>
      </div>
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