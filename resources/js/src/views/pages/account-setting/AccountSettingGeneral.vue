<template>
  <b-card>

    <!-- media -->
    <b-media no-body>
      <b-media-aside>
        <b-link>
          <b-img
            ref="previewEl"
            rounded
            :src="'/images/'+optionsLocal.avatar"
            height="80"
          />
        </b-link>
        <!--/ avatar -->
      </b-media-aside>

      <b-media-body class="mt-75 ml-75">
        <!-- upload button -->
        <b-form-file
          v-model="file1"
          :state="Boolean(file1)"
          placeholder="Alege o poză sau trage-o aici..."
          drop-placeholder="Trage poza aici"
        />
        <div class="mt-3">
          Fișier selectat: {{ file1 ? file1.name : '' }}
        </div>
        <!--/ upload button -->

        <!--        &lt;!&ndash; reset &ndash;&gt;-->
        <!--        <b-button-->
        <!--          v-ripple.400="'rgba(186, 191, 199, 0.15)'"-->
        <!--          variant="outline-secondary"-->
        <!--          size="sm"-->
        <!--          class="mb-75 mr-75"-->
        <!--        >-->
        <!--          Resetare-->
        <!--        </b-button>-->
        <!--/ reset -->
        <b-card-text>Permise: JPG, GIF sau PNG. Mărime maximă 800kB</b-card-text>
      </b-media-body>
    </b-media>
    <!--/ media -->

    <!-- form -->
    <b-form class="mt-2">
      <b-row>
        <b-col sm="6">
          <b-form-group
            label="Username"
            label-for="account-username"
          >
            <b-form-input
              v-model="optionsLocal.username"
              placeholder="Username"
              name="username"
              disabled
            />
          </b-form-group>
        </b-col>
        <b-col sm="6">
          <b-form-group
            label="Nume complet"
            label-for="account-name"
          >
            <b-form-input
              v-model="name"
              name="name"
              placeholder="Nume complet"
            />
          </b-form-group>
        </b-col>
        <b-col sm="6">
          <b-form-group
            label="E-mail"
            label-for="account-e-mail"
          >
            <b-form-input
              v-model="optionsLocal.email"
              name="email"
              placeholder="Email"
              disabled
            />

          </b-form-group>
        </b-col>
        <!--        <b-col sm="6">-->
        <!--          <b-form-group-->
        <!--            label="Numele companiei"-->
        <!--            label-for="account-company"-->
        <!--          >-->
        <!--            <b-form-input-->
        <!--              v-model="optionsLocal.company"-->
        <!--              name="company"-->
        <!--              placeholder="Numele companiei"-->
        <!--            />-->
        <!--          </b-form-group>-->
        <!--        </b-col>-->

        <!-- alert -->
        <b-col
          v-if="!emailNotConfirmed"
          cols="12"
          class="mt-75"
        >
          <b-alert
            show
            variant="warning"
            class="mb-50"
          >
            <h4 class="alert-heading">
              Adresa de email nu este confirmată. Vă rugăm să verificați emailul.
            </h4>
            <div class="alert-body">
              <b-link class="alert-link">
                Retrimitere email de confirmare
              </b-link>
            </div>
          </b-alert>
        </b-col>
        <!--/ alert -->

        <b-col cols="12">
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            class="mt-2 mr-1"
            @click="savePicture"
          >
            Salvează
          </b-button>
          <!--          <b-button-->
          <!--            v-ripple.400="'rgba(186, 191, 199, 0.15)'"-->
          <!--            variant="outline-secondary"-->
          <!--            type="reset"-->
          <!--            class="mt-2"-->
          <!--            @click.prevent="resetForm"-->
          <!--          >-->
          <!--            Resetare-->
          <!--          </b-button>-->
        </b-col>

        <b-col
          cols="12"
          class="mt-3"
        ><b-alert
          show
          variant="warning"
        >Atenție! Dupa orice modificare asupra contului este nevoie de reautentificare!</b-alert></b-col>
      </b-row>
    </b-form>
  </b-card>
</template>

<script>
import {
  BFormFile, BButton, BForm, BFormGroup, BFormInput, BRow, BCol, BAlert, BCard, BCardText, BMedia, BMediaAside, BMediaBody, BLink, BImg,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import axios from 'axios'
import useJwt from '@/auth/jwt/useJwt'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { initialAbility } from '@/libs/acl/config'

export default {
  components: {
    BButton,
    BForm,
    BImg,
    BFormFile,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BAlert,
    BCard,
    BCardText,
    BMedia,
    BMediaAside,
    BMediaBody,
    BLink,
  },
  directives: {
    Ripple,
  },
  props: {
    generalData: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      optionsLocal: null,
      file1: null,
      emailNotConfirmed: true,
      name: '',
    }
  },
  beforeMount() {
    this.$http.get('/api/user/data').then(res => {
      this.optionsLocal = res.data
      this.name = this.optionsLocal.fullName
      this.emailNotConfirmed = !!res.data.email_verified_at
    })
  },
  methods: {
    resetForm() {
      this.optionsLocal = null
    },
    savePicture() {
      const config = {
        headers: {
          Accept: 'application/json',
          'content-type': 'multipart/form-data',
          Authorization: `Bearer ${useJwt.getToken()}`,
        },
      }
      const data = new FormData()
      data.append('image', this.file1)
      data.append('name', this.name)
      if (this.file1 != null) {
        axios.post('/api/user/profile/image', data, config)
          .then(res => {
            if (res.status === 200) {
              this.optionsLocal.avatar = res.data.data
              this.$toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: 'Schimbări efectuare cu succes!',
                  icon: 'CoffeeIcon',
                  variant: 'success',
                  text: 'Te rugăm sa te reautentifici pentru a continua.',
                },
              })
              // Remove userData from localStorage
              // ? You just removed token from localStorage. If you like, you can also make API call to backend to blacklist used token
              localStorage.removeItem(useJwt.jwtConfig.storageTokenKeyName)
              localStorage.removeItem(useJwt.jwtConfig.storageRefreshTokenKeyName)

              // Remove userData from localStorage
              localStorage.removeItem('userData')

              // Reset ability
              this.$ability.update(initialAbility)

              // Redirect to login page
              this.$router.push({ name: 'auth-login' })
            } else {
              this.$toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: 'Datele nu au fost schimbate!',
                  icon: 'CoffeeIcon',
                  variant: 'error',
                  text: 'A aparut o eroare. Te rugăm încearcă mai târziu.',
                },
              })
            }
          })
        // eslint-disable-next-line no-unused-vars
          .catch(err => {
            this.$toast({
              component: ToastificationContent,
              position: 'top-right',
              props: {
                title: 'Poză nu a fost schimbată',
                icon: 'CoffeeIcon',
                variant: 'error',
                text: 'A aparut o eroare. Te rugăm încearcă mai târziu.',
              },
            })
          })
      } else {
        axios.post('/api/user/profile/name', data, config)
          .then(res => {
            if (res.status === 200) {
              this.optionsLocal.avatar = res.data.data
              this.$toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: 'Nume schimbat cu succes!',
                  icon: 'CoffeeIcon',
                  variant: 'success',
                  text: 'Numele a fost schimbat cu succes! Te rugăm sa te reautentifici pentru a continua.',
                },
              })
              // Remove userData from localStorage
              // ? You just removed token from localStorage. If you like, you can also make API call to backend to blacklist used token
              localStorage.removeItem(useJwt.jwtConfig.storageTokenKeyName)
              localStorage.removeItem(useJwt.jwtConfig.storageRefreshTokenKeyName)

              // Remove userData from localStorage
              localStorage.removeItem('userData')

              // Reset ability
              this.$ability.update(initialAbility)

              // Redirect to login page
              this.$router.push({ name: 'auth-login' })
            } else {
              this.$toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: 'Numele nu a fost schimbat',
                  icon: 'CoffeeIcon',
                  variant: 'error',
                  text: 'A aparut o eroare. Te rugăm încearcă mai târziu.',
                },
              })
            }
          })
        // eslint-disable-next-line no-unused-vars
          .catch(err => {
            this.$toast({
              component: ToastificationContent,
              position: 'top-right',
              props: {
                title: 'Numele nu a fost schimbat',
                icon: 'CoffeeIcon',
                variant: 'error',
                text: 'A aparut o eroare. Te rugăm încearcă mai târziu.',
              },
            })
          })
      }
    },
  },
  setup() {
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, previewEl)

    return {
      refInputEl,
      previewEl,
      inputImageRenderer,
    }
  },
}
</script>
