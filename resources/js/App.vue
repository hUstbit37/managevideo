<template>
  <div style="background-color: #f2f5f9">
    <Header v-if="!checkAdmin"></Header>
    <div :class="{container:!checkAdmin}">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Header from "./components/layout/Header.vue";
export default {
  data() {
    return {
      key: 0,
      checkAdmin: false,
    };
  },
  created() {
    console.log(this.$route.name);
    if (this.$route.name == "admin") {
      this.checkAdmin = true;
    }
  },
  components: {
    Header,
  },
};
</script>

<style scoped>
</style>