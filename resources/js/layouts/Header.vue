<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="dropdown" style="margin-left: 10px;">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-bars fa-lg" aria-hidden="true" style="cursor: pointer;"></i>
        </button>
        <div class="dropdown-menu">
          <span class="dropdown-item">
            <router-link class="nav-link" :to="{ name: 'home' }">
              <b>Home</b>
            </router-link>
          </span>
          <span class="dropdown-item">Trending</span>
          <span class="dropdown-item">Subcription</span>
        </div>
      </div>

      <div class="container">
        <span class="navbar-brand">
          <router-link :to="{name: 'home'}" style=" text-decoration: none; color: #000">
            <img :src="logo" alt width="40" style="padding-bottom: 10px; margin-left: 10px;" />
            <strong>Video4You</strong>
          </router-link>
        </span>

        <form>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" />
            <div class="input-group-append">
              <button class="input-group-text" type="submit">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </form>
        <div>
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto"></ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto" v-if="!check">
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'login' }">
                <b>Login</b>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'register' }">
                <b>Register</b>
              </router-link>
            </li>
          </ul>
          <ul class="navbar-nav mr-auto" v-if="check">
            <li class="nav-item">
              <a class="nav-link" href>
                <img
                  src="https://cdn3.iconfinder.com/data/icons/download-and-upload/512/Upload_Video-01-512.png"
                  width="32"
                  height="32"
                  alt
                /> Upload
              </a>
            </li>
            <li class="nav-item dropdown">
              <a
                id="navbarDropdown"
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <img
                  src="https://vnn-imgs-f.vgcloud.vn/2020/03/23/11/trend-avatar-6.jpg"
                  alt
                  width="32"
                  height="32"
                />
                {{username}}
                <!-- <span class="caret"></span> -->
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href>Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import { EventBus } from "../eventBusCheckAuth.js";
export default {
  name: "AppHeader",
  data() {
    return {
      logo: "./img/logo.svg",
      avatar: "./img/avatar-duc.png",
      check: false,
      username: "hang"
    };
  },
  created() {
    // this.isLogin();
  },
  mounted() {
    console.log(1);
    EventBus.$on("login", (checkLogin, name) => {
      this.check = checkLogin;
      this.username = name;
    });
  },
  methods: {}
};
</script>

<style lang="scss" scoped>
.container {
  padding-top: 0%;
  padding-left: 0%;
  padding-right: 0%;
  margin-left: 1%;
}
nav {
  padding-bottom: 0%;
  padding-top: 0%;
  margin-bottom: 1%;
  margin-left: 0%;
}
</style>