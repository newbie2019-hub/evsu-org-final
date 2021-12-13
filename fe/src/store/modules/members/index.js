import API from '../../base/';
import Vue from 'vue';
export default {
    namespaced: true,
    state: {
        allmembers: [],
        members: [],
        admins: [],
        pending_members: [],
        messages: [],
        chatusers: [],
    },
    getters: {},
    mutations: {
        SET_ALL_MEMBERS(state, data) {
            state.allmembers = data;
        },
        SET_MEMBERS(state, data) {
            state.members = data;
        },
        SET_CHAT_USERS(state, data) {
            state.chatusers = data;
        },
        SET_ADMINS(state, data) {
            state.admins = data;
        },
        SET_PENDING_MEMBERS(state, data) {
            state.pending_members = data;
        },
        UPDATE_MEMBER(state, data) {
            for (let i = 0; i < state.members.data.length; i++) {
                if (state.members.data[i].id == data.id) {
                    Vue.set(state.members.data, i, data);
                }
            }
        },

        SET_MESSAGES(state, data) {
            state.messages = data;
        },
    },
    actions: {
        async allMembers({ commit }) {
            const res = await API.get(`/user/members/all`)
                .then((res) => {
                    commit('SET_ALL_MEMBERS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async getMembers({ commit }, { page, sort }) {
            const res = await API.get(`/user/members?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_MEMBERS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async allAdmins({ commit }) {
            const res = await API.get(`/user/orgadmins`)
                .then((res) => {
                    commit('SET_ADMINS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async chatUsers({ commit }) {
            const res = await API.get(`/user/chatusers`)
                .then((res) => {
                    commit('SET_CHAT_USERS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async getPendingMembers({ commit }, { page, sort }) {
            const res = await API.get(`/user/pendingmembers?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_PENDING_MEMBERS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },

        async saveMember({ commit }, payload) {
            const res = await API.post('/user/members', payload)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },

        async sendMessage({ commit }, payload) {
            const res = await API.post('message', payload)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },

        async requestMessages({ commit }, data) {
            const res = await API.post('conversation/messages', data)
                .then((res) => {
                    commit('SET_MESSAGES', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },

        async updateMember({ commit }, payload) {
            const res = await API.put(`/user/members/${payload.id}`, payload)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async deleteMember({ commit }, payload) {
            const res = await API.delete(`/user/members/${payload.id}`)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async approveMember({ commit }, payload) {
            const res = await API.put(`/user/approve/${payload.id}`, payload)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        /** END OF ACTION */
    },
};