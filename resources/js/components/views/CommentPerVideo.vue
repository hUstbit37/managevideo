<template>
  <div>
    <div v-for="(item, index) in cmtPerVideo" :key="index">
      <div class="show-comment">
        <div class="media item-cmt">
          <img
            src="https://vnn-imgs-f.vgcloud.vn/2020/03/23/11/trend-avatar-6.jpg"
            alt="avatar"
            class="mr-3 mt-3 rounded-circle"
          />
          <div class="media-body">
            <div class="user-name">{{item.user.name}}</div>
            <div class="cmt-content">{{item.comment_content}}</div>
            <div>
              <i>{{moment(item.created_at).fromNow()}}</i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />
    <!-- <div v-if="isFullCmt" class="text-center">No more comment</div> -->
    <div style="padding:5px 0 20px 0">
      <button
        v-if="!isFullCmt"
        class="btn btn-outline-primary btn-block"
        @click="cmtPaganation()"
      >Load comment</button>
    </div>
  </div>
</template>

<script>
var moment = require("moment");
export default {
  created() {
    this.cmtPaganation();
  },

  props: ["id_video"],
  data() {
    return {
      moment: moment,
      cmtPerVideo: [],
      page: 1,
      isFullCmt: false,
      cmt_count: 0
    };
  },
  methods: {
    cmtPaganation() {
      axios
        .post("api/cmtPaganation/" + this.id_video, {
          id: this.id_video,
          page: this.page
        })
        .then(response => {
          console.log(response.data.cmt);
          response.data.cmt.forEach(item => {
            this.cmtPerVideo.push(item);
          });

          this.cmt_count = response.data.cmt_count;
          if (this.cmtPerVideo.length == response.data.cmt_count) {
            this.isFullCmt = !this.isFullCmt;
          }
        });
      this.page += 1;
    }
  }
};
</script>

<style lang="scss" scoped>
.show-comment {
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
</style>