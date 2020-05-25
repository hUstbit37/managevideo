<template>
  <div style="background-color: #f2f5f9">
    <Header></Header>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Header from "./components/layout/Header.vue";
export default {
  data() {
    return {
      key: 0
    };
  },
  mounted() {},
  components: {
    Header
  }
};
</script>

<style scoped>
</style>