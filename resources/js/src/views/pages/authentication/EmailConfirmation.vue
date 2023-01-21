<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">

      <!-- Brand logo-->
      <b-link class="brand-logo">
        <vuexy-logo />
        <h2 class="brand-text text-primary ml-1">
          Workbook
        </h2>
      </b-link>
      <!-- /Brand logo-->

      <!-- Left Text-->
      <b-col
        lg="8"
        class="d-none d-lg-flex align-items-center p-5"
      >
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <b-img
            fluid
            :src="imgUrl"
            alt="Login V2"
          />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Login-->
      <b-col
        lg="4"
        class="d-flex align-items-center auth-bg px-2 p-lg-5"
      >
        <b-col
          sm="8"
          md="6"
          lg="12"
          class="px-xl-2 mx-auto"
        >
          <b-card-title
            class="mb-1 font-weight-bold"
            title-tag="h2"
          >
            Confirmă adresa ta la Workbook!
          </b-card-title>
          <b-card-text class="mb-2">
            Confirmă adresa și bucură-te de beneficiile Workbook
          </b-card-text>

          <b-button
            type="submit"
            variant="primary"
            block
            @click="confirm()"
          >
            Confirmă
          </b-button>

          <b-card-text class="text-center mt-2">
            <span>Probleme cu email-ul? </span>
            <b-link :to="{name:'auth-register'}">
              <span>&nbsp;Retrimite email</span>
            </b-link> <br>
            <span>Nu uita sa verifici casuța de spam sau blocked! </span>
          </b-card-text>
        </b-col>
      </b-col>
    <!-- /Login-->
    </b-row>
  </div>
</template>

<script>
/* eslint-disable global-require */
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {
  BRow,
  BCol,
  BLink,
  BCardText,
  BCardTitle,
  BImg,
  BButton,
  VBTooltip,
} from 'bootstrap-vue'
import useJwt from '@/auth/jwt/useJwt'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'

import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import axios from 'axios'

export default {
  directives: {
    'b-tooltip': VBTooltip,
  },
  components: {
    BRow,
    BCol,
    BLink,
    BCardText,
    BCardTitle,
    BImg,
    BButton,
    VuexyLogo,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      status: '',
      password: '',
      userEmail: '',
      sideImg: require('@/assets/images/pages/reset-password-v2.svg'),

      // validation rules
      required,
      email,
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === 'dark') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require('@/assets/images/pages/reset-password-v2-dark.svg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {
    confirm() {
      const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
      })
      const confirmURL = params.verifyLink
      const config = {
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${useJwt.getToken()}`,
        },
      }
      axios.get(confirmURL, config)
        .then(res => {
          if (res.data.status === 200) {
            this.$toast({
              component: ToastificationContent,
              position: 'top-right',
              props: {
                title: 'Adresa a fost confirmată cu succes!',
                icon: 'CoffeeIcon',
                variant: 'success',
                text: 'Felicitări! Ai confirmat cu succes adresa de email.',
              },
            })
            this.$router.push('/')
          } else {
            this.$toast({
              component: ToastificationContent,
              position: 'top-right',
              props: {
                title: 'Adresa nu a putut fi confirmată.',
                icon: 'CoffeeIcon',
                variant: 'error',
                text: 'A aparut o eroare. Te rugăm încearcă mai târziu.',
              },
            })
          }
        })
    },
  },
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/pages/page-auth.scss';
</style>
