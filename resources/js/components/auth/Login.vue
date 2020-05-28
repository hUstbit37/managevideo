<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>

          <div class="card-body">
            <form @submit.prevent="login">
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">User name</label>
                <div class="col-md-6">
                  <input
                    id="name"
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': isError && errors.name}"
                    v-model="name"
                    autofocus
                    autocomplete="name"
                  />
                  <span class="invalid-feedback" v-if="isError && errors.name">{{ errors.name }}</span>
                  <!-- <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="email"
                    autofocus
                    autocomplete="email"
                  />-->
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    :class="{'is-invalid': isError && errors.password}"
                    v-model="password"
                  />
                  <span
                    class="invalid-feedback"
                    role="alert"
                    v-if="isError && errors.password"
                  >{{ errors.password }}</span>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                    <label class="form-check-label" for="remember">Remember</label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">Login</button>
                  <a class="btn btn-link">Forgot Your Password?</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "/var/www/ManageVideo/resources/js/eventBusCheckAuth.js";
export default {
  data() {
    return {
      name: "",
      password: "",
      email: "",
      checkLogin: false,
      errors: {},
      isError: false
    };
  },
  methods: {
    login() {
      axios
        .post("api/login", {
          name: this.name,
          password: this.password
        })
        .then(response => {
          if (response.data.check) {
            console.log(response.data);
            this.checkLogin = true;
            localStorage.setItem(
              "Video4You.user",
              JSON.stringify(response.data.user)
            );
            localStorage.setItem("Video4You.jwt", response.data.token);
            localStorage.setItem("user", response.data.name);
            EventBus.$emit("login", this.checkLogin, this.name);
            // this.name = response.data.name;
            this.$router.replace(this.$route.query.redirect || "/");
          }
        })
        .catch(error => {
          console.log(error.response.data.errors);
          this.errors = error.response.data.errors;
          this.isError = true;
        });
    }
  }
};
</script>

<style>
</style>