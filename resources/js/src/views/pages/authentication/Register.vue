<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">

      <!-- Brand logo-->
      <b-link class="brand-logo">
        <vuexy-logo />

        <h2 class="brand-text text-primary ml-1">
          MyThesis
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
            alt="Register V2"
          />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Register-->
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
          <b-card-title class="mb-1">
            Căutarea începe aici 🚀
          </b-card-title>
          <b-card-text class="mb-2">
            Proiectele tale devin realitate cu Workbook
          </b-card-text>

          <!-- form -->
          <validation-observer
            ref="registerForm"
            #default="{invalid}"
          >
            <b-form
              class="auth-register-form mt-2"
              @submit.prevent="register"
            >
              <!-- username -->
              <b-form-group
                label="Nume complet"
                label-for="register-fullname"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Nume complet"
                  vid="register-fullname"
                  rules="required"
                >
                  <b-form-input
                    id="register-fullname"
                    v-model="registerFullname"
                    name="register-fullname"
                    :state="errors.length > 0 ? false:null"
                    placeholder="Popescu Gabriel"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
              <!-- username -->
              <b-form-group
                label="Username"
                label-for="register-username"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Nume"
                  vid="username"
                  rules="required"
                >
                  <b-form-input
                    id="register-username"
                    v-model="username"
                    name="register-username"
                    :state="errors.length > 0 ? false:null"
                    placeholder="johndoe"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- email -->
              <b-form-group
                label="Email"
                label-for="register-email"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Email"
                  vid="email"
                  rules="required|email"
                >
                  <b-form-input
                    id="register-email"
                    v-model="userEmail"
                    name="register-email"
                    :state="errors.length > 0 ? false:null"
                    placeholder="john@example.com"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- password -->
              <b-form-group
                label-for="register-password"
                label="Parolă"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Password"
                  vid="password"
                  rules="required"
                >
                  <b-input-group
                    class="input-group-merge"
                    :class="errors.length > 0 ? 'is-invalid':null"
                  >
                    <b-form-input
                      id="register-password"
                      v-model="password"
                      class="form-control-merge"
                      :type="passwordFieldType"
                      :state="errors.length > 0 ? false:null"
                      name="register-password"
                      placeholder="············"
                    />
                    <b-input-group-append is-text>
                      <feather-icon
                        :icon="passwordToggleIcon"
                        class="cursor-pointer"
                        @click="togglePasswordVisibility"
                      />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
              <b-form-group
                label="Ai un cod de invitație? Adaugă-l mai jos"
                label-for="referral"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Cod referral"
                  vid="username"
                  rules="required"
                >
                  <b-form-input
                    id="referral"
                    v-model="referral"
                    name="referral"
                    :state="errors.length > 0 ? false:null"
                    placeholder="xxxx-xxxx-xxxx-xxxx"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
              <b-form-group>
                <b-form-checkbox
                  id="register-privacy-policy"
                  v-model="status"
                  name="checkbox-1"
                >
                  Sunt de acord cu
                  <b-link>Politica de Confidențialitate</b-link> și
                  <b-link>Termenii și Condițiile</b-link> Workbook
                </b-form-checkbox>
              </b-form-group>

              <b-button
                variant="primary"
                block
                :disabled="invalid"
                @click="register()"
              >
                Înregistrare
              </b-button>
            </b-form>
          </validation-observer>

          <p class="text-center mt-2">
            <span>Ai deja un cont?</span>
            <b-link :to="{name:'auth-login'}">
              <span>&nbsp;Autentifică-te</span>
            </b-link>
          </p>

          <!--          &lt;!&ndash; divider &ndash;&gt;-->
          <!--          <div class="divider my-2">-->
          <!--            <div class="divider-text">-->
          <!--              or-->
          <!--            </div>-->
          <!--          </div>-->

          <!--          <div class="auth-footer-btn d-flex justify-content-center">-->
          <!--            <b-button-->
          <!--              variant="facebook"-->
          <!--              href="javascript:void(0)"-->
          <!--            >-->
          <!--              <feather-icon icon="FacebookIcon" />-->
          <!--            </b-button>-->
          <!--            <b-button-->
          <!--              variant="twitter"-->
          <!--              href="javascript:void(0)"-->
          <!--            >-->
          <!--              <feather-icon icon="TwitterIcon" />-->
          <!--            </b-button>-->
          <!--            <b-button-->
          <!--              variant="google"-->
          <!--              href="javascript:void(0)"-->
          <!--            >-->
          <!--              <feather-icon icon="MailIcon" />-->
          <!--            </b-button>-->
          <!--            <b-button-->
          <!--              variant="github"-->
          <!--              href="javascript:void(0)"-->
          <!--            >-->
          <!--              <feather-icon icon="GithubIcon" />-->
          <!--            </b-button>-->
          <!--          </div>-->
        </b-col>
      </b-col>
    <!-- /Register-->
    </b-row>
  </div>
</template>

<script>
/* eslint-disable global-require */
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {
  BRow,
  BCol,
  BLink,
  BButton,
  BForm,
  BFormCheckbox,
  BFormGroup,
  BFormInput,
  BInputGroup,
  BInputGroupAppend,
  BImg,
  BCardTitle,
  BCardText,
} from 'bootstrap-vue'
// eslint-disable-next-line import/no-cycle
import useJwt from '@/auth/jwt/useJwt'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  components: {
    VuexyLogo,
    BRow,
    BImg,
    BCol,
    BLink,
    BButton,
    BForm,
    BCardText,
    BCardTitle,
    BFormCheckbox,
    BFormGroup,
    BFormInput,
    BInputGroup,
    BInputGroupAppend,
    // validations
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      status: '',
      username: '',
      userEmail: '',
      password: '',
      referral: '',
      registerFullname: '',
      sideImg: require('@/assets/images/pages/register-v2.svg'),
      // validation
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
        this.sideImg = require('@/assets/images/pages/register-v2-dark.svg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {
    register() {
      const self = this
      this.$refs.registerForm.validate().then(success => {
        if (success) {
          useJwt
            .register({
              fullName: this.registerFullname,
              username: this.username,
              email: this.userEmail,
              password: this.password,
              referral: this.referral,
            })
            .then(response => {
              useJwt.setToken(response.data.accessToken)
              useJwt.setRefreshToken(response.data.refreshToken)
              localStorage.setItem('userData', JSON.stringify(response.data.userData))
              this.$ability.update(response.data.userData.ability)
              this.$router.push('/')
            })
            .catch(error => {
              if (error.response.status === 403) {
                self.$router.replace('/register').then(() => {
                  self.$toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                      title: 'Codul de invitație introdus este invalid.',
                      icon: 'CoffeeIcon',
                      variant: 'danger',
                      text: 'Te rugăm să verifici codul folosit pentru invitație',
                    },
                  })
                })
              }
              if (error.response.status === 422) {
                self.$router.replace('/register').then(() => {
                  self.$toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                      title: 'Username sau email deja existent',
                      icon: 'CoffeeIcon',
                      variant: 'danger',
                      text: 'Te rugăm să incerci alte date sau sa te autentifici',
                    },
                  })
                })
              }
            })
        }
      })
    },
  },
}
/* eslint-disable global-require */
</script>

<style lang="scss">
@import '~@resources/scss/vue/pages/page-auth.scss';
</style>
