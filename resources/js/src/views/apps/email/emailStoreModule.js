import axios from '@axios'
import useJwt from '@/auth/jwt/useJwt'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchEmails(ctx, payload) {
      return new Promise((resolve, reject) => {
        const config = {
          headers: {
            Accept: 'application/json',
            Authorization: `Bearer ${useJwt.getToken()}`,
          },
        }
        axios
          .get('/api/apps/email/emails', config)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    updateEmail(ctx, payload) {
      return new Promise((resolve, reject) => {
        axios
          .post('/apps/email/update-emails', payload)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    updateEmailLabels(ctx, payload) {
      return new Promise((resolve, reject) => {
        axios
          .post('/apps/email/update-emails-label', payload)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    paginateEmail(ctx, payload) {
      return new Promise((resolve, reject) => {
        axios
          .get('/apps/email/paginate-email', { params: payload })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
