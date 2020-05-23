<template>
  <div class="container">
    <div>
      <form action>
        <input @keyup="testSearch" v-model="search_text" type="text" placeholder="Search..." />
        <!-- <i @click="testSearch" type="submit" class="fa fa-search" aria-hidden="true"></i> -->
      </form>
    </div>
    <span v-if="kq_count">Co {{kq_count}} ket qua phu hop</span>
    <table border="1" class="table tbl-1">
      <thead class="thead-dark">
        <th>#</th>
        <th>Name</th>
        <th>Age</th>
        <th>School</th>
      </thead>
      <tbody v-if="kq_count==0">
        <tr>
          <td colspan="4">Khong co data phu hop</td>
        </tr>
      </tbody>

      <tbody v-else>
        <tr v-for=" item in listData " :key="item.id">
          <td>{{item.id}}</td>
          <td v-html="`${item.name}`"></td>
          <td v-html="`${item.age}`"></td>
          <td v-html="`${item.school}`"></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      listData: {},
      search_text: "",
      kq_count: 1
    };
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      axios.get("testsearch.show").then(response => {
        this.listData = response.data;
      });
    },
    testSearch() {
      axios
        .post("testsearch.kq", { search: this.search_text })
        .then(response => {
          console.log(response.data.kq_count);
          this.listData = response.data.kq;
          this.kq_count = response.data.kq_count;
        });
    }
  }
};
</script>

<style lang="scss">
.container {
  padding-top: 20px;
}
table {
  width: 720px !important;
  th {
    text-align: center;
  }
  .tbl-1 th,
  .tbl-1 td {
    height: 30px;
    padding: 5px !important;
  }
  .tbl-1 td {
    font-size: 14px;
    font-weight: normal;
  }
}
</style>