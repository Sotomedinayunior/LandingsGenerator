<template>
  <form @submit.prevent="handleSubmit" class="login-form">
    <div class="form-group">
      <div :class="['icon-container', { shake: errors.email }]">
        <i class="fas fa-envelope"></i>
      </div>
      <input
        type="email"
        v-model="email"
        placeholder="Email"
        :class="{'error': errors.email}"
        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
        @input="clearError('email')"
      />
     
</div> <div class="container">      <p v-if="errors.email" class="error-message">{{ errors.email[0] }}</p>
    </div>
    <div class="form-group">
      <div :class="['icon-container', { shake: errors.password }]">
        <i class="fas fa-lock"></i>
      </div>
      <input
        :type="passwordFieldType"
        v-model="password"
        placeholder="Contraseña"
        :class="{'error': errors.password}"
        @input="clearError('password')"
        required
      />
      <i
        :class="passwordToggleIcon"
        @click="togglePasswordVisibility"
        class="toggle-password"
      ></i>
      
     
    </div><div class="container"> <p v-if="errors.password" class="error-message">{{ errors.password[0] }}</p></div>
    <button
      :disabled="loading"
      class="submit-button"
    >
      <span v-if="loading">Accediendo...</span>
      <span v-else>Acceder</span>
    </button>
  </form>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      email: "",
      password: "",
      showPassword: false,
      loading: false,
      errors: {} // Objeto para almacenar los errores
    };
  },
  computed: {
    passwordFieldType() {
      return this.showPassword ? "text" : "password";
    },
    passwordToggleIcon() {
      return this.showPassword ? "fas fa-eye-slash" : "fas fa-eye";
    },
  },
  methods: {
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    ...mapActions(["login"]),
    handleSubmit() {
      this.loading = true;
      this.errors = {}; // Resetear errores

      this.login({ email: this.email, password: this.password })
        .then(() => {
          this.loading = false;
          // Redirigir al dashboard
          this.$router.push("landings");
        })
        .catch((error) => {
          this.loading = false;
          console.error("Error en el inicio de sesión:", error);
          this.errors = error; // Asignar errores a la propiedad errors
        });
    },
    clearError(field) {
      this.$set(this.errors, field, []); // Limpiar errores del campo
    }
  },
};
</script>

<style scoped lang="scss">
.login-form {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  max-width: 300px;
  margin: 0 auto;
  padding: 20px;
  box-sizing: border-box;
}

.form-group {
  position: relative;
  width: 100%;
  margin-bottom: 25px;
}

.icon-container {
  position: absolute;
  top: 50%;
  left: 10px;
  transform: translateY(-50%);
  color: #999; /* Color del icono */
  transition: transform 0.3s; /* Transición suave para la animación */
  z-index: 1; /* Asegurarse de que el icono esté encima del campo de entrada */
}

.icon-container.shake {
  animation: shake 0.3s; /* Animación de error */
}

.form-group input {
  width: 100%;
  padding: 12px 10px 12px 40px; /* Espacio para el icono */
  border: 1px solid #ddd; /* Color del borde */
  border-radius: 8px;
  box-sizing: border-box;
  font-family: sans-serif;
}

.form-group input.error {
  border-color: #e74c3c; /* Color del borde en caso de error */
}

.form-group input:focus {
  outline: none;
}

.error-message {
  color: #e74c3c;
  font-size: 0.75em;
  margin-top: -24px; /* Margen superior para el mensaje de error */
}

.toggle-password {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #999; /* Color del icono */
  z-index: 1; /* Asegurarse de que el icono esté encima del campo de entrada */
}

.submit-button {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 8px;
  background-color: #f16822;
  color: white;

  cursor: pointer;
  transition: background-color 0.3s;
}

.submit-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.submit-button:hover {
  background-color: #d5551d;
}

@keyframes shake {
  0% { transform: translateX(-2px); }
  50% { transform: translateX(2px); }
  100% { transform: translateX(0); }
}

@media (max-width: 600px) {
  .login-form {
    padding: 10px;
  }
}
</style>
