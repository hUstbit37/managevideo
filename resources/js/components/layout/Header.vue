<template>
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid">
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

      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto">
        <li></li>
      </ul>

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
      <ul class="navbar-nav ml-auto" v-if="check">
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'upload'}">
            <img
              src="https://cdn3.iconfinder.com/data/icons/download-and-upload/512/Upload_Video-01-512.png"
              width="32"
              height="32"
              alt
            /> Upload
          </router-link>
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
            <a @click="logout" class="dropdown-item" href>Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import { EventBus } from "/var/www/ManageVideo/resources/js/eventBusCheckAuth.js";
export default {
  data() {
    return {
      logo: "./img/logo.svg",
      avatar: "./img/avatar-duc.png",
      check: false,
      username: "toan"
    };
  },
  mounted() {
    EventBus.$on("login", (checkLogin, name) => {
      this.check = checkLogin;
      this.username = name;
    });
    if (localStorage.getItem("user")) {
      this.check = true;
      this.username = localStorage.getItem("user");
    }
    // this.isLogin();
  },
  methods: {
    logout() {
      localStorage.removeItem("user");
      localStorage.removeItem("Video4You.user");
      localStorage.removeItem("Video4You.jwt");
      this.$router.replace(this.$route.query.redirect || "/login");
    }
  }
};
</script>

<style scoped>
.navbar {
  min-height: 50px;
  height: 60px;
}
.navbar-nav.navbar-center {
  margin-left: auto;
  margin-right: auto;
  left: 0;
  right: 0;
}
</style>