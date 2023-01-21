<template>
  <b-card>
    <!-- form -->
    <b-form>
      <b-row>
        <b-col md="6">
          <b-form-group
            label-for="code"
            label="Codul tau de referral. Poți invita alte persoane pe MyThesis folosind acest cod."
          >
            <b-form-input
              id="code"
              v-model="refCode"
              class="form-control"
              :raw="false"
              placeholder="Cod referral"
              disabled
            />
          </b-form-group>
          <b-alert
            show
            variant="warning"
            class="mb-50"
          >
            <div class="alert-body">
              Pentru a accesa toate beneficiile pachetelor, este nevoie ca persoanele invitate sa fie confirmate mai jos.
            </div>
          </b-alert>
          <b-col md="12">
            <h3>Persoanele invitate de tine:</h3>
            <b-table
              striped
              hover
              :items="invitedPeople"
            />
            <span v-if="!invitedPeople">Nu ai invitat pe nimeni</span>
          </b-col>
        </b-col>
      </b-row>
    </b-form>
  </b-card>
</template>

<script>
import {
  BForm, BFormGroup, BRow, BCol, BCard, BTable, BFormInput, BAlert,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'

// eslint-disable-next-line import/no-extraneous-dependencies
import 'cleave.js/dist/addons/cleave-phone.us'

export default {
  components: {
    BForm,
    BFormGroup,
    BTable,
    BRow,
    BCol,
    BCard,
    BFormInput,
    BAlert,
  },
  directives: {
    Ripple,
  },
  props: {
    informationData: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      invitedPeople: null,
      refCode: null,
    }
  },
  beforeCreate() {
    this.$http.get('/api/user/referral/data').then(res => { this.invitedPeople = res.data.invitedPeople; this.refCode = res.data.refCode; console.log(res) })
    console.log(this.invitedPeople)
  },
  methods: {
    resetForm() {
      this.localOptions = JSON.parse(JSON.stringify(this.informationData))
    },
  },
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-select.scss';
@import '~@resources/scss/vue/libs/vue-flatpicker.scss';
</style>
