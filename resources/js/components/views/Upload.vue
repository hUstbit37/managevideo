<template>
  <div>
    <form @submit.prevent="upload" enctype="multipart/form-data">
      <input style="cursor: pointer;" type="file" @change="handleFileChange" />
      <button type="submit" class="btn btn-danger">
        <span class="fa fa-upload">Upload</span>
      </button>
    </form>

    <hr />
    <v-app>
      <v-card>
        <v-list dense>
          <v-list-tile>
            <v-list-tile-action>
              <v-icon>home</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>Home</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile>
            <v-list-tile-action>
              <v-icon>contact_mail</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>Contact</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-card>

      <v-content>
        <!-- <v-text-field
          width="300"
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>-->
        <v-data-table :headers="headers" :items="listVideo" :search="search">
          <template v-slot:item.video_name="{ item }">
            <span id="itemName">
              <strong>{{ item.video_name }}</strong>
            </span>
          </template>
        </v-data-table>
      </v-content>
    </v-app>

    <!-- <div v-if="mess">{{mess}}</div>
    <div v-else>
      <div v-for="(item, index) in listVideo" :key="index">
        <video width="300px" controls="controls">
          <source :src="`video/${item.video_name}`" type="video/mp4" />
        </video>
        <div class="video-name">
          <strong>{{item.video_name}}</strong>
        </div>
      </div>
    </div>-->
  </div>
</template>

</template>

<script>
export default {
  data() {
    return {
      search: "",
      headers: [
        { text: "Name", align: "start", value: "video_name" },
        { text: "Created_at", value: "created_at" },
        { text: "Like", value: "like" },
        { text: "View", value: "view" },
        { text: "Action" }
      ],
      file: "",
      listVideo: [],
      mess: false,
      id: null
    };
  },
  mounted() {
    this.id = JSON.parse(localStorage.getItem("Video4You.user")).id;
    this.showUserVideo();
  },

  methods: {
    showUserVideo() {
      axios.post("api/showUserVideo", { id: this.id }).then(response => {
        if (response.data) {
          this.listVideo = response.data;
        } else {
          this.mess = "You don't have any videos";
        }
      });
    },
    handleFileChange(e) {
      this.file = e.target.files[0];
      console.log(this.file.name);
    },
    upload() {
      let formData = new FormData();
      formData.append("file", this.file);
      formData.append("id", this.id);
      const config = {
        headers: {
          "content-type": "multipart/form-data"
        }
      };
      axios
        .post("api/upload", formData, config)
        .then(response => {
          console.log(response.data.video_upload);
          this.listVideo.unshift(response.data.video_upload);
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