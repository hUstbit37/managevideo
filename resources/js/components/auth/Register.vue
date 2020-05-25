<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <strong>Register</strong>
          </div>

          <div class="card-body">
            <form @submit.prevent="register">
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                <div class="col-md-6">
                  <input
                    id="name"
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': isError && errors.name}"
                    v-model="name"
                    autofocus
                  />
                  <span class="invalid-feedback" v-if="isError && errors.name">{{ errors.name }}</span>
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    :class="{'is-invalid': isError && errors.email}"
                    v-model="email"
                  />
                  <span class="invalid-feedback" v-if="isError && errors.email">{{ errors.email }}</span>
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
                <label
                  for="password-confirm"
                  class="col-md-4 col-form-label text-md-right"
                >Confirm Password</label>
                <div class="col-md-6">
                  <input
                    id="password-confirm"
                    type="password"
                    class="form-control"
                    :class="{'is-invalid': isError && errors.c_password}"
                    v-model="c_password"
                  />
                  <span
                    class="invalid-feedback"
                    v-if="isError && errors.c_password"
                  >{{ errors.c_password }}</span>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">Register</button>
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
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      c_password: "",
      errors: {},
      isError: false
    };
  },
  methods: {
    register() {
      axios
        .post("api/register", {
          name: this.name,
          email: this.email,
          password: this.password,
          c_password: this.c_password
        })
        .then(response => {
          console.log(response);
          this.$router.replace(this.$route.query.redirect || "/login");
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