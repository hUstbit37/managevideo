<template>
  <div>
    <label class="file-select">
      <div class="select-button">
        <i class="fa fa-upload"></i>
        <span v-if="value">{{value.name}}</span>
        <span v-else>Select File</span>
      </div>
      <input type="file" @change="handleFileChange" />
    </label>
    <div v-if="value"></div>
    <hr />
    <div v-if="mess">{{mess}}</div>
    <div v-else>
      <div v-for="(item, index) in listVideo" :key="index">
        <video width="300px" controls="controls">
          <source :src="`video/${item.video_name}`" type="video/mp4" />
        </video>
        <div class="video-name">
          <strong>{{item.video_name}}</strong>
        </div>
      </div>
    </div>
  </div>
</template>

</template>

<script>
export default {
  data() {
    return {
      value: 0,
      listVideo: {},
      mess: false
    };
  },
  created() {
    this.getVideo2();
  },
  methods: {
    getVideo2() {
      axios.get("api/getVideo2").then(response => {
        if (response.data) {
          this.listVideo = response.data;
        } else {
          this.mess = "You don't have any videos";
        }
      });
    },
    handleFileChange(e) {
      let id = JSON.parse(localStorage.getItem("Video4You.user")).id;
      console.log(id);
      console.log(e.target.files);
      this.value = e.target.files[0];
      let formData = new FormData();
      formData.append("file", this.value);
      let axiosConfig = {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      };
      //id chua dc truyen ve server
      axios
        .post("api/upload", formData, id, axiosConfig)
        .then(response => {
          this.listVideo = response.data.listVideo;
        })
        .catch(error => {
          console.log(error.response.data.errors);
        });
    }
  }
};
</script>

<style scoped>
label:hover {
  background-color: #981818;
}

.file-select > .select-button {
  cursor: pointer;
  padding: 8px;
  color: white;
  background-color: #d21717;
  border-radius: 0.2rem;
  text-align: center;
  font-weight: bold;
}

.file-select > input[type="file"] {
  display: none;
}
</style>