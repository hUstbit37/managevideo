<template>
  <v-app>
    <v-main>
      <v-card>
        <v-toolbar flat color="white">
          <v-toolbar-title>My Videos</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-text-field
            dense
            v-model="search"
            append-icon="search"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
          <v-spacer></v-spacer>

          <v-dialog v-model="dialogNew" persistent width="700px" height="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New Video</v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">New Video</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-text-field v-model="video.name" label="Video name"></v-text-field>
                  <v-select
                    v-model="video.categories"
                    :items="categories"
                    :menu-props="{ maxHeight: '200' }"
                    label="Category"
                    multiple
                  ></v-select>
                  <v-file-input
                    prepend-icon="mdi-camera"
                    label="Thumnbail "
                    v-model="video.thumbnail"
                  ></v-file-input>
                  <v-file-input label="File Video " v-model="video.path"></v-file-input>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialogNew=false">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="upload">Upload</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>

        <v-data-table
          :items-per-page="5"
          :headers="headers"
          :items="listVideo"
          :search="search"
          width="100%"
        >
          <template v-slot:top>
            <v-dialog v-model="dialogEdit" persistent max-width="700px">
              <v-card>
                <v-card-title>
                  <span class="headline">Edit Video</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-text-field v-model="video.name" label="Video name"></v-text-field>
                    <v-select
                      v-model="video.categories"
                      :items="categories"
                      :menu-props="{ maxHeight: '200' }"
                      label="Category"
                      multiple
                    ></v-select>
                    <v-file-input
                      prepend-icon="mdi-camera"
                      label="Thumnbail "
                      v-model="video.thumbnail"
                    ></v-file-input>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="dialogEdit=false">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="saveVideo">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </template>

          <template v-slot:item.video_name="{ item }">
            <span id="itemName">
              <strong>{{ item.video_name }}</strong>
              <br />
              <img
                style="width:80px; height:80px"
                :src="`./../video/thumbnails/${item.video_thumbnail}`"
                alt="thumbnail"
              />
            </span>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-icon @click="editItem(item)">mdi-pencil</v-icon>
            <v-icon @click="deleteVideo(item)">mdi-delete</v-icon>
          </template>
          <template v-slot:item.created_at="{ item }">
            <span>{{formatDate(item.created_at)}}</span>
          </template>
        </v-data-table>
      </v-card>
    </v-main>
  </v-app>
</template>



<script>
export default {
  data() {
    return {
      video_edit: null,
      dialogNew: false,
      dialogEdit: false,
      search: "",
      video: {
        name: "",
        thumbnail: "",
        categories: "",
        path: "",
      },
      headers: [
        { text: "Name", align: "start", value: "video_name", width: "500px" },
        { text: "Date", value: "created_at", width: "220px" },
        { text: "Likes", value: "like", width: "100px" },
        { text: "Views", value: "view", width: "100px" },
        { text: "Actions", value: "actions", sortable: false, width: "100px" },
      ],
      file: "",
      listVideo: [],
      mess: false,
      id: null,

      categories: [
        "funny",
        "animal",
        "romantic",
        "cartoon",
        "showbiz",
        "kpop",
        "tenis",
        "football",
        "music",
      ],
    };
  },
  mounted() {
    this.id = JSON.parse(localStorage.getItem("Video4You.user")).id;
    this.showUserVideo();
  },

  methods: {
    showUserVideo() {
      axios.post("api/showUserVideo", { id: this.id }).then((response) => {
        if (response.data) {
          this.listVideo = response.data;
        } else {
          this.mess = "You don't have any videos";
        }
      });
    },

    upload() {
      let formData = new FormData();
      if (this.video.thumbnail) {
        formData.append("fileThumbnail", this.video.thumbnail);
      }
      if (this.video.path) {
        formData.append("fileVideo", this.video.path);
      }
      formData.append("fileName", this.video.name);
      formData.append("fileCategory", this.video.categories);
      formData.append("id", this.id);
      if (this.video_edit) {
        formData.append("video_id", this.video_edit);
      }
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      axios
        .post("api/upload", formData, config)
        .then((response) => {
          console.log(response.data.video_upload);

          this.listVideo.unshift(response.data.video_upload);
        })
        .catch((error) => {
          console.log(error.response.data.errors);
        });
      this.video.name = "";
      this.video.path = "";
      this.video.thumbnail = "";
      this.video.categories = "";
      this.dialogNew = false;
    },
    editItem(item) {
      this.video.name = item.video_name;
      this.video_edit = item.id;
      // this.video.thumbnail = item.video_thumbnail;
      this.dialogEdit = true;
      console.log(item);
    },
    saveVideo() {
      this.upload();
      this.dialogEdit = false;
    },
    formatDate(date) {
      return date.substr(0, 16).replace("T", " ");
    },
    deleteVideo(item) {
      axios.get("api/delete/" + item.id).then((response) => {
        console.log(response.data);
        if (response.data) {
          this.listVideo.forEach((e) => {
            if (e.id == item.id) {
              let index = this.listVideo.indexOf(item);
              this.listVideo.splice(index, 1);
            }
          });
        }
      });
    },
  },
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