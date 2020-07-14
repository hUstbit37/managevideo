<template>
  <div>
    <div class="row justify-content-center">
      <div class="input-group" style="width:640px; padding:0px !important; margin:0px">
        <input v-model="search_name" type="text" class="form-control" placeholder="Search" />
        <div class="input-group-append">
          <button class="input-group-text" @click="search">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
      <div id="list-video">
        <div v-for="(item, index) in list_video" :key="index">
          <div id="video-desc">
            <div class="media">
              <div style="margin-right: 5px">
                <img
                  src="https://vnn-imgs-f.vgcloud.vn/2020/03/23/11/trend-avatar-6.jpg"
                  alt="avatar"
                  class="media-object rounded-circle"
                  width="60"
                />
              </div>
              <div class="media-body">
                <div id="follow_area">
                  <span id="channel">
                    <strong>{{item.user.name}}</strong>
                  </span>

                  <span class="follow" v-if="id_user_loggedIn==item.user.id"></span>
                  <span
                    class="follow"
                    v-if="id_user_loggedIn!==item.user.id && !friendListId.includes(item.user.id)"
                    @click="sub(item.user.id)"
                  >Follow</span>
                  <span
                    class="follow"
                    v-if="id_user_loggedIn!==item.user.id && friendListId.includes(item.user.id)"
                    @click="sub(item.user.id)"
                  >Following</span>

                  <!-- <span style="color:#216fdb;font-weight:bold;cursor:pointer;">Follow</span> -->
                </div>
                <i>
                  <small>{{moment(item.created_at).fromNow()}}</small>
                </i>
              </div>
            </div>

            <div class="video-name">
              <span>{{item.video_name}}</span>
            </div>
            <!-- <hr /> -->

            <video width="640px" controls="controls" id="video" preload="metadata">
              <source :src="`video/${item.video_name}#t=${10+index}`" type="video/mp4" />
            </video>
          </div>

          <div class="comment-area">
            <div>
              <form class="form-group" @submit.prevent="addComment(item.id)">
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

            <div v-for="(cmt, index) in cmtAdded" :key="index">
              <div id="show-comment">
                <div class="media item-cmt" v-if="isAddCmt==item.id">
                  <img
                    src="https://vnn-imgs-f.vgcloud.vn/2020/03/23/11/trend-avatar-6.jpg"
                    alt="avatar"
                    class="mr-3 mt-3 rounded-circle"
                  />
                  <div class="media-body">
                    <div class="user-name">{{name_user_loggedIn}}</div>
                    <div class="cmt-content">{{cmt.comment_content}}</div>
                    <div>
                      <i>{{moment(cmt.created_at).fromNow()}}</i>
                    </div>
                    <!-- <hr /> -->
                  </div>
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
      cmtAdded: [],
      list_video: {},
      comment: {
        content: [],
        id: 0
      },
      moment: moment,
      videoMoreExists: true,
      page: 2,
      friendListId: null,
      search_name: null
    };
  },
  created() {
    this.getVideo();
  },

  methods: {
    // init() {
    //   var _video = document.getElementById("video");
    //   _video.addEventListener("playing", play_clicked, false);
    // },

    // play_clicked() {
    //   alert("play was clicked");
    // },
    getVideo() {
      if (this.isLoggedIn) {
        let user = JSON.parse(localStorage.getItem("Video4You.user"));
        console.log(user);
        this.id_user_loggedIn = user.id;
        this.name_user_loggedIn = user.name;

        axios
          .post("api/show.video", { id: this.id_user_loggedIn })
          .then(resp => {
            console.log(resp.data.list);
            this.list_video = resp.data.list;
            this.friendListId = resp.data.friendListId;
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
          if (response.data.list.length < 2) {
            this.videoMoreExists = false;
          }
          response.data.list.forEach(data => {
            this.list_video.push(data);
          });
          this.page += 1;
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
          this.cmtAdded.unshift(response.data.unitCmt);
          // this.cmtAdded = response.data.unitCmt;
          this.messCmtAdded = response.data.mess;
          this.isAddCmt = id;
          this.comment.content[id] = "";
        });
    },

    sub($friendId) {
      axios
        .post("api/sub", {
          user_id: this.id_user_loggedIn,
          friend_id: $friendId
        })
        .then(response => {
          // console.log(response.data.check);
          if (response.data.check) {
            alert("Ban vua huy theo doi kenh nay");
            let index = this.friendListId.indexOf($friendId);
            this.friendListId.splice(index, 1);
          } else {
            alert("Ban vua theo doi kenh");
            this.friendListId.push($friendId);
          }
          // this.showVideo();
        });
    },
    search() {
      if (this.search_name !== null) {
        axios
          .post("api/search", { search: this.search_name })
          .then(response => {
            console.log(response.data.kq);
            this.list_video = response.data.kq;
            this.videoMoreExists = false;
          });
      }
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
    .media-body {
      background-color: #f0f2f5 !important;
      border-radius: 11px;
      padding: 3px;
    }
    .rounded-circle {
      width: 50px;
    }
    .user-name {
      font-size: 18px;
      font-weight: bold;
      color: blue;
    }
    .cmt-content {
      font-size: 15px;
    }
    i {
      font-size: 13px;
      color: #999;
    }
  }
}
#follow_area {
  .follow {
    color: #216fdb;
    font-weight: bold;
    cursor: pointer;
  }
  #channel {
    color: black;
    font-size: 19px;
    padding-right: 8px;
  }
}
</style>