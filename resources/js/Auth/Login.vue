<template>
  <div class="d-flex justify-content-center h-100">
    <div v-if="checkLogin">
      Ban da login thanh cong, chuyen den
      <router-link class="nav-link" :to="{ name: 'home' }">
        <b>Home</b>
      </router-link>
    </div>
    <div class="card">
      <div class="card-header">
        <h3>Sign In</h3>
        <!-- <div class="d-flex justify-content-end social_icon">
            <span>
              <i class="fa fa-facebook-square"></i>
            </span>
            <span>
              <i class="fa fa-google-plus-square"></i>
            </span>
            <span>
              <i class="fa fa-twitter-square"></i>
            </span>
        </div>-->
      </div>
      <div class="card-body">
        <form @submit.prevent="login">
          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fa fa-user"></i>
              </span>
            </div>
            <input v-model="name" type="text" class="form-control" placeholder="username" />
          </div>
          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fa fa-key"></i>
              </span>
            </div>
            <input v-model="password" type="password" class="form-control" placeholder="password" />
          </div>

          <div class="row align-items-center remember">
            <input type="checkbox" />Remember Me
          </div>
          <div class="form-group">
            <input type="submit" value="Login" class="btn float-right login_btn" />
          </div>
        </form>
      </div>
      <div class="card-footer">
        <div class="d-flex justify-content-center">
          <div>
            <a href="#">Forgot your password?</a>
            <br />Don't have an account?
            <router-link class="nav-link" :to="{ name: 'register' }">
              <b>Sign Up</b>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../eventBusCheckAuth.js";
export default {
  data() {
    return {
      name: "",
      password: "",
      checkLogin: false
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
            console.log(response);
            this.checkLogin = response.data.check;
            this.name = response.data.name;

            EventBus.$emit("login", this.checkLogin, this.name);

            this.$router.replace(this.$route.query.redirect || "/");
          }
        })
        .catch(error => {
          console.log(error.response.data.errors);
        });
    }
  }
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css?family=Numans");

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
  background-color: white;
}

.links {
  color: black;
}

.links a {
  margin-left: 4px;
}
</style>