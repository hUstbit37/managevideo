<template>
  <div class="d-flex justify-content-center h-100">
    <div class="card">
      <div class="card-header">
        <h3>Register</h3>
      </div>
      <div class="card-body">
        <form @submit.prevent="register">
          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fa fa-user"></i>
              </span>
            </div>
            <input
              v-model="name"
              type="text"
              class="form-control"
              :class="{'is-invalid': isError && errors.name}"
              placeholder="username"
            />
            <span class="invalid-feedback" v-if="isError && errors.name">{{ errors.name }}</span>
          </div>

          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fa fa-envelope"></i>
              </span>
            </div>
            <input
              v-model="email"
              type="email"
              class="form-control"
              :class="{'is-invalid': isError && errors.email}"
              placeholder="email"
            />
            <span class="invalid-feedback" v-if="isError && errors.email">{{ errors.email }}</span>
          </div>

          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fa fa-key"></i>
              </span>
            </div>
            <input
              v-model="password"
              type="password"
              class="form-control"
              :class="{'is-invalid': isError && errors.password}"
              placeholder="password"
            />
            <span class="invalid-feedback" v-if="isError && errors.password">{{ errors.password }}</span>
          </div>
          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fa fa-key"></i>
              </span>
            </div>
            <input
              v-model="c_password"
              type="password"
              class="form-control"
              :class="{'is-invalid': isError && errors.c_password}"
              placeholder="comfirm password"
            />
            <span
              class="invalid-feedback"
              v-if="isError && errors.c_password"
            >{{ errors.c_password }}</span>
          </div>

          <div class="form-group">
            <input type="submit" value="Register" class="btn float-right login_btn" />
          </div>
        </form>
      </div>
      <div class="card-footer">
        <div class="d-flex justify-content-center">
          <button class="btn btn-primary">Register with Facbook</button>
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
          this.$router.replace(this.$route.query.redirect || "/");
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

<style scoped>
.card {
  margin-top: auto;
  margin-bottom: auto;
  width: 400px;
  /* background-color: rgba(0, 0, 0, 0.5) !important; */
}

.social_icon span {
  font-size: 60px;
  margin-left: 10px;
  color: #ffc312;
}

.social_icon span:hover {
  color: white;
  cursor: pointer;
}

.card-header h3 {
  color: black;
}

.social_icon {
  position: absolute;
  right: 20px;
  top: -45px;
}

.input-group-prepend span {
  width: 50px;
  background-color: #ffc312;
  color: black;
  border: 0 !important;
}

input:focus {
  outline: 0 0 0 0 !important;
  box-shadow: 0 0 0 0 !important;
}

.remember {
  color: black;
}

.remember input {
  width: 20px;
  height: 20px;
  margin-left: 15px;
  margin-right: 5px;
}

.login_btn {
  color: black;
  background-color: #ffc312;
  width: 100px;
}

.login_btn:hover {
  color: black;
  background-color: #3490dc;
}

.links {
  color: black;
}

.links a {
  margin-left: 4px;
}
</style>