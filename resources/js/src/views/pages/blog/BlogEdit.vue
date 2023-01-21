<template>
  <b-card
    class="blog-edit-wrapper"
  >
    <!-- media -->
    <b-media
      no-body
      vertical-align="center"
    >

      <b-media-body>
        <h6 class="mb-25" />
        <b-card-text />
      </b-media-body>
    </b-media>
    <!--/ media -->

    <!-- form -->
    <b-form class="mt-2">
      <b-row>
        <b-col md="6">
          <b-form-group
            label="Titlu"
            label-for="blog-edit-title"
            class="mb-2"
          >
            <b-form-input
              id="blog-edit-title"
              v-model="title"
            />
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-form-group
            label="Categorie"
            label-for="blog-edit-category"
            class="mb-2"
          >
            <v-select
              id="blog-edit-category"
              v-model="jobPost.blogCategories"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              multiple
              :options="categoryOption"
            />
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-form-group
            label="Descriere scurtă"
            label-for="blog-edit-slug"
            class="mb-2"
          >
            <b-form-input
              id="blog-edit-slug"
              v-model="excerpt"
            />
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-form-group
            label="Locatie"
            label-for="blog-edit-slug"
            class="mb-2"
          >
            <b-form-input
              id="blog-edit-slug"
              v-model="location"
            />
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-form-group
            label="Număr de contact"
            label-for="blog-edit-slug"
            class="mb-2"
          >
            <b-form-input
              id="blog-edit-slug"
              v-model="phone"
            />
          </b-form-group>
        </b-col>
        <b-col cols="12">
          <b-form-group
            label="Conținutul anunțului"
            label-for="blog-content"
            class="mb-2"
          >
            <quill-editor
              id="blog-content"
              v-model="content"
              :options="snowOption"
            />
          </b-form-group>
        </b-col>
        <b-col
          cols="12"
          class="mb-2"
        >
          <div class="border rounded p-2">
            <h4 class="mb-1">
              Imaginea anunțului
            </h4>
            <b-media
              no-body
              vertical-align="center"
              class="flex-column flex-md-row"
            >
              <b-media-aside>
                <b-img
                  ref="refPreviewEl"
                  :src="blogFile"
                  height="110"
                  width="170"
                  class="rounded mr-2 mb-1 mb-md-0"
                />
              </b-media-aside>
              <b-media-body>
                <small class="text-muted">Rezoluția necesară a imaginii 800x400, dimensiunea imaginii 10mb.</small>
                <b-card-text class="my-50">
                  <b-link id="blog-image-text">
                    {{ blogFile ? blogFile.name : 'banner_anunt.jpg' }}
                  </b-link>
                </b-card-text>
                <div class="d-inline-block">
                  <b-form-file
                    ref="refInputEl"
                    v-model="blogFile"
                    accept=".jpg, .png, .gif"
                    placeholder="Alege o imagine reprezentativă"
                    @input="inputImageRenderer"
                  />
                </div>
              </b-media-body>
            </b-media>
          </div>
        </b-col>
        <b-col
          cols="12"
          class="mt-50"
        >
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            class="mr-1"
            @click="savePost()"
          >
            Postează
          </b-button>
          <b-button
            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
            variant="outline-secondary"
          >
            Anulare
          </b-button>
        </b-col>
      </b-row>
    </b-form>
    <!--/ form -->
  </b-card>
</template>

<script>
import {
  BCard,
  BMedia,
  BAvatar,
  BCardText,
  BMediaAside,
  BMediaBody,
  BForm,
  BRow,
  BCol,
  BFormGroup,
  BFormInput,
  BImg,
  BFormFile,
  BLink,
  BButton,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import { quillEditor } from 'vue-quill-editor'
import Ripple from 'vue-ripple-directive'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import useJwt from '@/auth/jwt/useJwt'
import axios from 'axios'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  components: {
    BCard,
    BMedia,
    BAvatar,
    BCardText,
    BMediaAside,
    BMediaBody,
    BForm,
    BLink,
    BImg,
    BRow,
    BCol,
    BButton,
    BFormGroup,
    BFormInput,
    BFormFile,
    vSelect,
    quillEditor,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      jobPost: {},
      blogFile: null,
      content: '',
      location: '',
      title: '',
      excerpt: '',
      phone: '',
      categoryOption: ['Fashion', 'Food', 'Gaming', 'Quote', 'Video'],
      statusOption: ['Published', 'Pending', 'Draft'],
      snowOption: {
        theme: 'snow',
      },
    }
  },
  created() {
    // this.$http.get('/blog/list/data/edit').then(res => {
    //   this.blogEdit = res.data
    // })
  },
  methods: {
    savePost() {
      const config = {
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${useJwt.getToken()}`,
        },
      }
      const data = new FormData()
      data.append('image', this.blogFile)
      data.append('title', this.title)
      data.append('category_id', '')
      data.append('tags', '')
      data.append('excerpt', this.excerpt)
      data.append('content', this.content)
      data.append('phone', this.phone)
      data.append('location', this.location)
      axios.post('/api/job/new', data, config).then(res => {
        if (res.data.status === 200) {
          this.$toast({
            component: ToastificationContent,
            position: 'top-right',
            props: {
              title: 'Anunț publicat',
              icon: 'CoffeeIcon',
              variant: 'success',
              text: 'Anunțul tău a fost publicat cu succes.',
            },
          })
          this.$router.push(`/jobs/${res.data.id}`)
        }
      })
    },
  },
  setup() {
    const refInputEl = ref(null)
    const refPreviewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      refPreviewEl.value.src = base64
    })

    return {
      refInputEl,
      refPreviewEl,
      inputImageRenderer,
    }
  },
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';
@import '~@resources/scss/vue/libs/quill.scss';
@import '~@resources/scss/vue/pages/page-blog.scss';
</style>
