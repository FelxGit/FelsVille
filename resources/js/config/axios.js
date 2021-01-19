import Vue from 'Vue'
import axios from 'axios'
import { store } from '../store/'

const instance = axios.create({
    baseURL: 'http://localhost:8080' // put base or your app might concatenate the url
  })

// before a request is made
instance.interceptors.request.use(config => {
  
  config.headers['Content-Type'] = 'application/json'
  config.headers['Authorization'] = 'Bearer ' + localStorage.getItem('fhive.jwt')

  store.dispatch('loading_update', true)
  return config
})

// before a response is returned
instance.interceptors.response.use(response => {

  store.dispatch('loading_update', false)
  return response
})
export default instance
