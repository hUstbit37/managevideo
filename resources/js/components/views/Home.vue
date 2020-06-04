<template>
  <div>
    <div class="row justify-content-center">
      <div id="list-video">
        <div v-for="(item, index) in list_video" :key="index">
          <video width="640px" controls="controls" id="video">
            <source :src="`video/${item.video_name}`" type="video/mp4" />
          </video>

          <div id="video-desc">
            <i>
              <small>Uploaded at: {{moment(item.created_at).fromNow()}}</small>
            </i>
            <div class="video-name">
              <h4>{{item.video_name}}</h4>
            </div>

            <div class="row" id="subciption">
              <div class="col-md-8">
                <div class="media">
                  <div class="media-left media-middle" style="margin-right: 5px">
                    <a href="#">
                      <img
                        src="https://vnn-imgs-f.vgcloud.vn/2020/03/23/11/trend-avatar-6.jpg"
                        alt="avatar"
                        class="media-object"
                        width="50"
                        height="50"
                      />
                    </a>
                  </div>
                  <div class="media-body media-middle">
                    <div class="media-heading" style="font-size: 14px">
                      <a href="#" class>{{item.user.name}}</a>
                    </div>
                    <div role="group" aria-label="..." class="btn-group btn-group-sm">
                      <button class="btn btn-subscribe btn-danger">
                        <i class="fa fa-play">Subscribe</i>
                      </button>
                      <button disabled="disabled" class="btn btn-default">100000</button>
                    </div>
                  </div>
                </div>
                <hr />
              </div>
            </div>
          </div>

          <div class="comment-area">
            <div>
              <form id="form-comment" class="form-group" @submit.prevent="addComment(item.id)">
                <textarea
                  class="comment-textarea"
                  v-model="comment.content[item.id]"
                  name="comment_content"
                  placeholder="Write comment.."
                ></textarea>
                <div class="text-right">
                  <button type="reset" class="btn btn-secondary">Cancer</button>
                  <button type="submit" class="btn btn-primary">Comment</button>
                </div>
              </form>
            </div>

            <div id="show-comment">
              <div class="media item-cmt" v-if="isAddCmt==item.id">
                <img
                  src="https://vnn-imgs-f.vgcloud.vn/2020/03/23/11/trend-avatar-6.jpg"
                  alt="avatar"
                  class="mr-3 mt-3 rounded-circle"
                />
                <div class="media-body">
                  <div class="user-name">{{name_user_loggedIn}}</div>
                  <div class="cmt-content">{{cmtAdded.comment_content}}</div>
                  <div>
                    <i>{{moment(cmtAdded.created_at).fromNow()}}</i>
                  </div>
                  <hr />
                </div>
              </div>
            </div>
            <CommentPerVideo :id_video="item.id"></CommentPerVideo>
          </div>
          <hr />
        </div>
      </div>
    </div>
    <div style="margin-bottom: 15px" class="text-center" v-if="videoMoreExists">
      <button type="button" class="btn btn-primary" @click="loadMoreVideo()">
        <span class="fa fa-arrow-down"></span>
        Load More
      </button>
    </div>
  </div>
</template>

<script>
var moment = require("moment");
import CommentPerVideo from "./CommentPerVideo.vue";
export default {
  data() {
    return {
      isLoggedIn: localStorage.getItem("Video4You.jwt") != null,
      id_user_loggedIn: null,
      name_user_loggedIn: null,
      isAddCmt: false,
      cmtAdded: {},
      list_video: {},
      comment: {
        content: [],
        id: 0
      },
      moment: moment,
      videoMoreExists: true,
      page: 2
    };
  },
  created() {
    this.getVideo();
  },

  methods: {
    init() {
      var _video = document.getElementById("video");
      _video.addEventListener("playing", play_clicked, false);
    },

    play_clicked() {
      alert("play was clicked");
    },
    getVideo() {
      if (this.isLoggedIn) {
        let user = JSON.parse(localStorage.getItem("Video4You.user"));
        this.id_user_loggedIn = user.id;
        this.name_user_loggedIn = user.name;
        this.checkAuth = true;

        axios
          .post("api/show.video", { id: this.id_user_loggedIn })
          .then(resp => {
            console.log(resp.data.list);
            this.list_video = resp.data.list;
            // if (resp.data.current_page < resp.data.last_page) {
            //   this.videoMoreExists = true;
            //   this.nextPage = resp.data.current_page + 1;
            // } else {
            //   this.videoMoreExists = false;
            // }
          })
          .catch(error => console.log(error));
      } else {
        this.$router.replace(this.$route.query.redirect || "/login");
      }
    },
    loadMoreVideo() {
      axios
        .post("api/loadMoreVideo", {
          page: this.page,
          id: this.id_user_loggedIn
        })
        .then(response => {
          // console.log(response.data.list);
          if (response.data.list.video_count == 0) {
            this.videoMoreExists = false;
          }
          response.data.list.forEach(data => {
            this.list_video.push(data);
          });
          this.page += 1;
          // if (response.data.current_page < response.data.last_page) {
          //   this.videoMoreExists = true;
          //   this.nextPage = resp.data.current_page + 1;
          // } else {
          //   this.videoMoreExists = false;
          // }
          // response.data.data.forEach(data => {
          //   this.list_video.push(data);
          // });
        });
    },
    addComment(id) {
      this.comment.id = id;
      axios
        .post("api/add.comment/" + id, {
          comment_id_user: this.id_user_loggedIn,
          comment_content: this.comment.content[id],
          comment_id_video: this.comment.id
        })
        .then(response => {
          this.cmtAdded = response.data.unitCmt;
          this.messCmtAdded = response.data.mess;
          this.isAddCmt = id;
          this.comment.content[id] = "";
        });
    }
  },
  components: {
    CommentPerVideo
  }
};
</script>

<style lang="scss" scoped>
#list-video {
  width: 640px;
  #video-desc,
  .comment-area {
    background-color: white;
    box-sizing: border-box;
    border: 1px solid transparent;
    padding: 10px 0 10px 0;
    margin: 15px 0 20px 0;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.05);
  }
  .video-name {
    text-align: left;
    font-size: 18px;
  }
  .comment-textarea {
    width: 640px;
    margin-bottom: 5px;
  }
  textarea {
    display: block;
    width: 100%;
    border: 0;
    padding: 10px 5px;
    background: white no-repeat;

    background-image: linear-gradient(to bottom, #1abc9c, #1abc9c),
      linear-gradient(to bottom, silver, silver);
    background-size: 0 2px, 100% 1px;
    background-position: 50% 100%, 50% 100%;
    transition: background-size 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
  }
  textarea:focus {
    background-size: 100% 2px, 100% 1px;
    outline: none;
  }
}
#show-comment {
  .item-cmt {
    width: 640px;
    padding: 5px;
    font: Arial;
    .rounded-circle {
      width: 60px;
    }
    .user-name {
      font-size: 19px;
      font-weight: bold;
      color: blue;
    }
    .cmt-content {
      font-size: 16px;
    }
    i {
      font-size: 14px;
      color: #999;
    }
  }
}
</style>