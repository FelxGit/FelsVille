import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export const store =  new Vuex.Store({
  state: {
      loading: true
  },
  getters: {
    get_status: (state) => {
      return state.loading
    }
  },
  mutations: {
    loading_changes: (state, payload) => {
      state.loading = payload
    }
  },
  actions: {
    loading_update: (context, payload) => {
      context.commit('loading_changes',payload)
    }
  },
  modules: {}
})
