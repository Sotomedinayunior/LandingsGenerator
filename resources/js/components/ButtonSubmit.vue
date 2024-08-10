<template>
    <button :type="tyEvent">{{ text }}</button>
</template>
  
  <script>
  export default {
    props: {
      text: {
        type: String,
        default: 'Submit'
      }
      ,typeEvent:{
        type:String,
        default:'button'
        
      }
    }
  };
  </script>
  
  <style scoped lang="scss">
  button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 4px;
    background: $color-background-secondary;
    color: $color-font-tertiary;
    font-size:1em;
    cursor: pointer;
    font-family: $font-family-base;
  }
  
  button:hover {
    background: darken($color-background-secondary, 10%);
  }


/* Responsive Styles */
@media (max-width: 768px) {
  button {
    font-size: 14px;
    padding: 8px;
  }
}

@media (max-width: 480px) {
  button {
    font-size: 12px;
    padding: 6px;
  }
}
  </style>
  