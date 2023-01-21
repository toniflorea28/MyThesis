<template>
  <content-with-sidebar
    v-if="Object.keys(blogDetail).length"
    class="cws-container cws-sidebar-right blog-wrapper"
  >

    <!-- content -->
    <div class="blog-detail-wrapper">
      <b-row>
        <!-- blogs -->
        <b-col cols="12">
          <b-card
            :img-src="blogDetail.blog.img"
            img-top
            img-alt="Blog Detail Pic"
            :title="blogDetail.blog.title"
            :class="{ inactive: !blogDetail.blog.active }"
          >
            <b-media no-body>
              <b-media-aside
                vertical-align="center"
                class="mr-50"
              >
                <b-avatar
                  href="javascript:void(0)"
                  size="24"
                  :src="blogDetail.blog.avatar"
                />
              </b-media-aside>
              <b-media-body>
                <small class="text-muted mr-50">de către</small>
                <small>
                  <b-link class="text-body">{{ blogDetail.blog.userFullName }} ({{ blogDetail.blog.username }})</b-link>
                </small>
                <span class="text-muted ml-75 mr-50">|</span>
                <small class="text-muted">{{ blogDetail.blog.createdTime }}</small>
              </b-media-body>
            </b-media>
            <div class="my-1 py-25">
              <b-link
                v-for="tag in blogDetail.blog.tags"
                :key="tag"
              >
                <b-badge
                  pill
                  class="mr-75"
                  :variant="tagsColor(tag)"
                >
                  {{ tag }}
                </b-badge>
              </b-link>
            </div>
            <!-- eslint-disable vue/no-v-html -->
            <div
              class="blog-content"
              v-html="blogDetail.blog.content"
            />

            <!-- user commnets -->
            <b-media
              v-for="user in blogDetail.blog.UserComment"
              :key="user.avatar"
              no-body
            >
              <b-media-aside>
                <b-avatar
                  size="60"
                  :src="user.avatar"
                />
              </b-media-aside>
              <b-media-body>
                <h6 class="font-weight-bolder">
                  {{ user.fullName }}
                </h6>
                <b-card-text>
                  {{ user.comment }}
                </b-card-text>
              </b-media-body>
            </b-media>
            <!-- eslint-enable -->
            <hr class="my-2">

            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center mr-1">
                  <b-link class="mr-50">
                    <feather-icon
                      icon="PhoneIcon"
                      size="21"
                      class="text-body"
                    />
                  </b-link>
                  <b-link>
                    <div class="text-body">
                      {{ blogDetail.blog.phone }}
                    </div>
                  </b-link>
                </div>
                <div class="d-flex align-items-center">
                  <b-link class="mr-50">
                    <feather-icon
                      size="21"
                      icon="BookmarkIcon"
                      class="text-body"
                    />
                  </b-link>
                  <b-link>
                    <div class="text-body">
                      {{ blogDetail.blog.location }}
                    </div>
                  </b-link>
                </div>
              </div>
              <div v-if="blogDetail.blog.user_id == userData.id">
                <div
                  v-if="blogDetail.blog.active"
                  class="d-flex align-items-center mr-1"
                  @click="toggleJob()"
                >
                  <b-link class="mr-50">
                    <feather-icon
                      icon="DeleteIcon"
                      size="21"
                      class="text-body"
                    />
                  </b-link>
                  <b-link>
                    <div class="text-body">
                      Dezactivează postarea
                    </div>
                  </b-link>
                </div>
                <div
                  v-else
                  class="d-flex align-items-center mr-1"
                  @click="toggleJob()"
                >
                  <b-link class="mr-50">
                    <feather-icon
                      icon="CheckIcon"
                      size="21"
                      class="text-body"
                    />
                  </b-link>
                  <b-link>
                    <div class="text-body">
                      Activează postarea
                    </div>
                  </b-link>

                </div>
              </div>
            </div>
          </b-card>
        </b-col>
        <!--/ blogs -->
      </b-row>
      <!--/ blogs -->
    </div>
  </content-with-sidebar>
</template>

<script>
import {
  BMedia,
  BAvatar,
  BMediaAside,
  BMediaBody,
  BLink,
  BCard,
  BRow,
  BCol,
  BBadge,
  BCardText,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import ContentWithSidebar from '@core/layouts/components/content-with-sidebar/ContentWithSidebar.vue'
// eslint-disable-next-line import/no-cycle
import useJwt from '@/auth/jwt/useJwt'

export default {
  components: {
    BMedia,
    BAvatar,
    BMediaAside,
    BMediaBody,
    BLink,
    BCard,
    BRow,
    BCol,
    BBadge,
    BCardText,
    ContentWithSidebar,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      userData: JSON.parse(localStorage.getItem('userData')),
      search_query: '',
      commentCheckmark: '',
      blogDetail: [],
      blogSidebar: {},
      socialShareIcons: ['GithubIcon', 'GitlabIcon', 'FacebookIcon', 'TwitterIcon', 'LinkedinIcon'],
    }
  },
  created() {
    const jobId = window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
    this.$http.get(`/api/job/list/data/detail/${jobId}`).then(res => {
      this.blogDetail = res.data
    })
    this.$http.get('/api/job/list/data/sidebar').then(res => {
      this.blogSidebar = res.data
    })
  },
  methods: {
    tagsColor(tag) {
      if (tag === 'Quote') return 'light-info'
      if (tag === 'Gaming') return 'light-danger'
      if (tag === 'Fashion') return 'light-primary'
      if (tag === 'Video') return 'light-warning'
      if (tag === 'Food') return 'light-success'
      return 'light-primary'
    },
    toggleJob() {
      const jobId = this.blogDetail.blog.id
      const config = {
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${useJwt.getToken()}`,
        },
      }
      this.$http.delete(`/api/job/toggle/${jobId}`, config).then(res => {
        if (res.status === 204) {
          this.$router.push('/user/jobs/list')
        }
      })
    },
  },
}
</script>

<style lang="scss" scoped>
@import '~@resources/scss/vue/pages/page-blog.scss';
.inactive {

    img {
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%);
    }

    h4::before {
        content: '[DEZACTIVAT] ';
        color: red;
    }
}
</style>
