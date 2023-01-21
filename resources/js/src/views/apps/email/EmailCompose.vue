<template>
  <b-modal
    id="compose-mail"
    :visible="shallShowEmailComposeModal"
    title="Compose Email"
    modal-class="modal-sticky"
    footer-class="d-flex justify-content-between"
    body-class="p-0"
    size="lg"
    no-fade
    hide-backdrop
    static
    @change="(val) => $emit('update:shall-show-email-compose-modal', val)"
  >
    <!-- Modal Header -->
    <template #modal-header>
      <h5 class="modal-title">
        Scrie un mesaj
      </h5>
      <div class="modal-actions">
        <feather-icon
          icon="MinusIcon"
          class="cursor-pointer"
          @click="$emit('update:shall-show-email-compose-modal', false)"
        />
        <feather-icon
          icon="Maximize2Icon"
          class="ml-1 cursor-pointer"
        />
        <feather-icon
          icon="XIcon"
          class="ml-1 cursor-pointer"
          @click="discardEmail"
        />
      </div>
    </template>

    <!-- Modal Footer -->
    <template #modal-footer>
      <!-- Footer: Left Content -->
      <div>
        <b-button
          v-ripple.400="'rgba(255, 255, 255, 0.15)'"
          split
          text="Send"
          variant="primary"
          right
          @click="sendEmail()"
        >
          Trimite mesaj
          <!--          <b-dropdown-item>-->
          <!--            Schedule Send-->
          <!--          </b-dropdown-item>-->
        </b-button>
        <!--        <feather-icon-->
        <!--          icon="PaperclipIcon"-->
        <!--          size="17"-->
        <!--          class="ml-2 cursor-pointer"-->
        <!--        />-->
      </div>

      <!--      &lt;!&ndash; Footer: Right Content &ndash;&gt;-->
      <!--      <div>-->

      <!--        &lt;!&ndash; Dropdown: More Actions &ndash;&gt;-->
      <!--        <b-dropdown-->
      <!--          variant="link"-->
      <!--          no-caret-->
      <!--          toggle-class="p-0"-->
      <!--          right-->
      <!--        >-->
      <!--          <template #button-content>-->
      <!--            <feather-icon-->
      <!--              icon="MoreVerticalIcon"-->
      <!--              size="17"-->
      <!--              class="text-body"-->
      <!--            />-->
      <!--          </template>-->

      <!--          <b-dropdown-item>-->
      <!--            Add Label-->
      <!--          </b-dropdown-item>-->

      <!--          <b-dropdown-item>-->
      <!--            Plain Text Mode-->
      <!--          </b-dropdown-item>-->

      <!--          <b-dropdown-divider />-->

      <!--          <b-dropdown-item>-->
      <!--            Print-->
      <!--          </b-dropdown-item>-->
      <!--          <b-dropdown-item>-->
      <!--            Check Spelling-->
      <!--          </b-dropdown-item>-->
      <!--        </b-dropdown>-->

      <!--        &lt;!&ndash; Discard Compose &ndash;&gt;-->
      <!--        <feather-icon-->
      <!--          icon="TrashIcon"-->
      <!--          size="17"-->
      <!--          class="ml-75 cursor-pointer"-->
      <!--          @click="discardEmail"-->
      <!--        />-->
      <!--      </div>-->
    </template>

    <!-- Modal: Body -->
    <b-form>

      <!-- Field: To -->
      <div class="compose-mail-form-field">
        <label
          for="email-to"
          class="form-label"
        >Către: </label>
        <div class="compose-mail-form-field flex-grow-1 email-to-selector">
          <b-form-input
            id="email-subject"
            v-model="messageFor"
            placeholder="Username sau email"
          />
        </div>

        <!--            :options="emailToOptions"-->
        <!--          <template #option="{ avatar, name }">-->
        <!--            <b-avatar-->
        <!--              size="sm"-->
        <!--              :src="avatar"-->
        <!--            />-->
        <!--            <span class="ml-50"> {{ name }}</span>-->
        <!--          </template>-->

        <!--          <template #selected-option="{ avatar, name }">-->
        <!--            <b-avatar-->
        <!--              size="sm"-->
        <!--              class="border border-white"-->
        <!--              :src="avatar"-->
        <!--            />-->
        <!--            <span class="ml-50"> {{ name }}</span>-->
        <!--          </template>-->
        <!--        <span-->
        <!--          class="cursor-pointer"-->
        <!--          @click="showCcField=!showCcField"-->
        <!--        >Cc</span>-->
        <!--        <span-->
        <!--          class="ml-1 cursor-pointer"-->
        <!--          @click="showBccField=!showBccField"-->
        <!--        >Bcc</span>-->
      </div>

      <!-- Field: Cc (Hidden Initially) -->
      <div
        v-show="showCcField"
        class="compose-mail-form-field"
      >
        <label for="email-cc">CC: </label>
        <v-select
          v-model="composeData.cc"
          :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
          multiple
          label="name"
          class="flex-grow-1 email-cc-selector"
          :close-on-select="false"
          input-id="email-cc"
        >

          <!--          <template #option="{ avatar, name }">-->
          <!--            <b-avatar-->
          <!--              size="sm"-->
          <!--              :src="avatar"-->
          <!--            />-->
          <!--            <span class="ml-50"> {{ name }}</span>-->
          <!--          </template>-->

          <!--          <template #selected-option="{ avatar, name }">-->
          <!--            <b-avatar-->
          <!--              size="sm"-->
          <!--              class="border border-white"-->
          <!--              :src="avatar"-->
          <!--            />-->
          <!--            <span class="ml-50"> {{ name }}</span>-->
          <!--          </template>-->
        </v-select>
      </div>

      <!-- Field: Bcc (Hidden Initially) -->
      <div
        v-show="showBccField"
        class="compose-mail-form-field"
      >
        <label for="email-bcc">Bcc </label>
        <v-select
          v-model="composeData.bcc"
          :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
          multiple
          label="name"
          class="flex-grow-1 email-bcc-selector"
          :close-on-select="false"

          input-id="email-bcc"
        >
          <!--            :options="emailToOptions"-->
          <template #option="{ avatar, name }">
            <b-avatar
              size="sm"
              :src="avatar"
            />
            <span class="ml-50"> {{ name }}</span>
          </template>

          <template #selected-option="{ avatar, name }">
            <b-avatar
              size="sm"
              class="border border-white"
              :src="avatar"
            />
            <span class="ml-50"> {{ name }}</span>
          </template>
        </v-select>
      </div>

      <!-- Field: Subject -->
      <div class="compose-mail-form-field">
        <label for="email-subject">Titlu: </label>
        <b-form-input
          id="email-subject"
          v-model="messageSubject"
          placeholder="Titlul mesajului"
        />
      </div>

      <!-- Field: Message - Quill Editor -->
      <div class="message-editor">
        <quill-editor
          id="quil-content"
          v-model="messageContent"
          :options="editorOption"
        />
        <div
          id="quill-toolbar"
          class="d-flex border-bottom-0"
        >
          <!-- Add a bold button -->
          <button class="ql-bold" />
          <button class="ql-italic" />
          <button class="ql-underline" />
          <button class="ql-align" />
          <button class="ql-link" />
        </div>
      </div>
    </b-form>

  </b-modal>
</template>

<script>
import {
  BDropdown, BDropdownItem, BForm, BFormInput, BAvatar, BDropdownDivider, BButton,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { ref } from '@vue/composition-api'
import { quillEditor } from 'vue-quill-editor'
import vSelect from 'vue-select'
import useJwt from '@/auth/jwt/useJwt'
import axios from 'axios'
import ToastificationContent from '@core/components/toastification/ToastificationContent'

export default {
  directives: {
    Ripple,
  },
  components: {
    // BSV
    BDropdown,
    BDropdownItem,
    BForm,
    BFormInput,
    BAvatar,
    BDropdownDivider,
    BButton,

    // 3rd Party
    quillEditor,
    vSelect,
  },
  model: {
    prop: 'shallShowEmailComposeModal',
    event: 'update:shall-show-email-compose-modal',
  },
  props: {
    shallShowEmailComposeModal: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      messageFor: '',
      messageSubject: '',
      messageContent: '',
    }
  },
  methods: {
    sendEmail() {
      const data = {
        messageFor: this.messageFor,
        messageSubject: this.messageSubject,
        messageContent: this.messageContent,
      }
      const config = {
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${useJwt.getToken()}`,
        },
      }
      console.log(config)
      axios.post('/api/apps/email/send', data, config)
        .then(res => {
          console.log(res)
          if (res.status === 200) {
            this.$toast({
              component: ToastificationContent,
              position: 'top-right',
              props: {
                title: 'Mesaj trimis!',
                icon: 'CoffeeIcon',
                variant: 'success',
                text: 'Mesajul a fost trimis și este pe drum!',
              },
            })
            this.$emit('update:shall-show-email-compose-modal', false)
            this.$router.go()
          } else if (res.status === 404) {
            this.$toast({
              component: ToastificationContent,
              position: 'top-right',
              props: {
                title: 'A aparut o eroare!',
                icon: 'CoffeeIcon',
                variant: 'danger',
                text: 'Nu am gasit niciun utilizator cu acel username sau email!',
              },
            })
          } else {
            this.$toast({
              component: ToastificationContent,
              position: 'top-right',
              props: {
                title: 'A aparut o eroare!',
                icon: 'CoffeeIcon',
                variant: 'danger',
                text: 'Pare că nu ai completat toate câmpurile corespunzător. Verifică și reîncearcă.',
              },
            })
          }
        })
    },
  },
  setup(_, { emit }) {
    const composeData = ref({})
    const showCcField = ref(false)
    const showBccField = ref(false)

    const editorOption = {
      modules: {
        toolbar: '#quill-toolbar',
      },
      placeholder: 'Mesajul tău',
    }

    /* eslint-disable global-require */
    const emailToOptions = [
      { avatar: require('@/assets/images/avatars/1-small.png'), name: 'Jane Foster' },
      { avatar: require('@/assets/images/avatars/3-small.png'), name: 'Donna Frank' },
      { avatar: require('@/assets/images/avatars/5-small.png'), name: 'Gabrielle Robertson' },
      { avatar: require('@/assets/images/avatars/7-small.png'), name: 'Lori Spears' },
      { avatar: require('@/assets/images/avatars/9-small.png'), name: 'Sandy Vega' },
      { avatar: require('@/assets/images/avatars/11-small.png'), name: 'Cheryl May' },
    ]
    /* eslint-enable global-require */

    const discardEmail = () => {
      composeData.value = {}
      emit('update:shall-show-email-compose-modal', false)
    }

    return {
      composeData,
      editorOption,
      emailToOptions,
      showCcField,
      showBccField,

      discardEmail,
    }
  },
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';
@import '~@resources/scss/vue/libs/quill.scss';
</style>

<style lang="scss" scoped>
form ::v-deep {
  // Mail To vue-select style
  .v-select {
    .vs__dropdown-toggle {
      border: 0;
      box-shadow: none;
    }
    .vs__open-indicator {
      display: none;
    }
  }

  // Quill Editor Style
  .quill-editor {
    .ql-container.ql-snow {
      border-bottom: 0 !important;
    }
  }
}
</style>
