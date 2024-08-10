<template>
  <form @submit.prevent="handleSubmit" class="login-form">
    <div class="form-group">
      <i class="fas fa-envelope" id="icon"></i>
      <input type="email" v-model="email" placeholder="Email" required />
    </div>
    <div class="form-group">
      <i class="fas fa-lock" id="icon"></i>
      <input
        :type="passwordFieldType"
        v-model="password"
        placeholder="Password"
        required
      />
      <i
        :class="passwordToggleIcon"
        @click="togglePasswordVisibility"
        class="toggle-password"
      ></i>
    </div>
    <ButtonComponent text="Ingresar" typeEvent="submit" />
  </form>
</template>

<script>
import { mapActions } from 'vuex';
import ButtonComponent from "./ButtonSubmit.vue";

export default {
  components: { ButtonComponent },
  data() {
    return {
      email: "",
      password: "",
      showPassword: false,
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
    ...mapActions(['login']),
    handleSubmit() {
      this.login({ email: this.email, password: this.password })
        .then(() => {
          // Redirigir al dashboard
          this.$router.push('/dashboard');
        })
        .catch(error => {
          console.error('Error en el inicio de sesión:', error);
        });
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
  margin-bottom: 15px;
}

.form-group #icon {
  position: absolute;
  top: 50%;
  left: 10px;
  transform: translateY(-50%);
  color: $color-font-secondary;
}

.form-group input {
  width: 100%;
  padding: 12px 10px 12px 40px;
  border: 1px solid $color-border-primary;
  border-radius: 8px;
  box-sizing: border-box;
  font-family: $font-family-base;
}

.form-group input:focus {
  border-color: $color-border-secondary;
  outline: none;
}

.form-group .toggle-password {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: $color-font-secondary;
}

@media (max-width: 600px) {
  .login-form {
    padding: 10px;
  }
}
</style>
