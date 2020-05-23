<template>
  <div>
    <app-header></app-header>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import AppHeader from "../layouts/Header.vue";
export default {
  components: {
    AppHeader
  }
};
</script>

<style scoped>
.container {
  /* width: 100% !important; */
}
</style>