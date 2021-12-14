import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export const USER = 'User';
export const AUTH = 'Auth';

const store = new Vuex.Store({
    state: {
        auth: {},
        user: null
    },
    mutations: {
        initStore(state) {
            const auth = localStorage.getItem(AUTH);
            if (auth) state.auth = JSON.parse(auth)

            const user = localStorage.getItem(USER);
            if (user) state.user = JSON.parse(user)
        },
        setAuthData(state, payload) {
            if (!localStorage.getItem(AUTH)) {
                localStorage.setItem(AUTH, JSON.stringify(payload))
                state.auth = payload;
            }
        },
        setUserData(state, payload) {
            if (!localStorage.getItem(USER)) {
                localStorage.setItem(USER, JSON.stringify(payload))
                state.user = payload;
            }
        },
        clearData(state){
            state.user = {};
            state.auth = {};
            localStorage.clear();
        }
    },
    actions: {
        setData({ commit }, payload) {
            commit(`set${payload.type}Data`, payload.data)
        },
        logout({ commit }){
            commit('clearData');
        }
    },
    getters: {
        isLoggedIn: state => !!state.auth.token,
        auth: state => state.auth,
        user: state => state.user
    }
})


export default store;