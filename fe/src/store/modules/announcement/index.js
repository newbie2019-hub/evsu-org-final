import API from '../../base/';
import Vue from 'vue';
export default {
    namespaced: true,
    state: {
        allannouncements: [],
        announcements: [],
        announcements1: [],
    },
    getters: {},
    mutations: {
        SET_ALL_ANNOUNCEMENTS(state, data) {
            state.allannouncements = data;
        },
        SET_ANNOUNCEMENTS(state, data) {
            state.announcements = data;
        },
        SET_ANNOUNCEMENTS1(state, data) {
            state.announcements1 = data;
        },
        UPDATE_ANNOUNCEMENT(state, data) {
            console.log(data);
            for (let i = 0; i < state.announcements.data.length; i++) {
                if (state.announcements.data[i].id == data.id) {
                    state.announcements.data[i].what = data.what;
                    state.announcements.data[i].where = data.where;
                    state.announcements.data[i].when = data.when;
                    state.announcements.data[i].who = data.who;
                }
            }
        },
    },
    actions: {
        async allAnnouncements({ commit }, { page, sort }) {
            const res = await API.get(`/user/announcement/all?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_ALL_ANNOUNCEMENTS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async getAnnouncements({ commit }, { page, sort }) {
            const res = await API.get(`/user/announcement?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_ANNOUNCEMENTS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async getAnnouncements1({ commit }, { page, sort }) {
            const res = await API.get(`/user/announcement/formembers?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_ANNOUNCEMENTS1', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async saveAnnouncement({ commit }, payload) {
            const res = await API.post('/user/announcement', payload)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async updateAnnouncement({ commit }, payload) {
            const res = await API.put(`/user/announcement/${payload.id}`, payload)
                .then((res) => {
                    commit('UPDATE_ANNOUNCEMENT', payload);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },

        async updateAnnouncement1({ commit }, payload) {
            const res = await API.put(`/admin/announcement/update/${payload.id}`, payload)
                .then((res) => {
                    commit('UPDATE_ANNOUNCEMENT', payload);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async deleteAnnouncement({ commit }, payload) {
            const res = await API.delete(`/user/announcement/${payload.id}`)
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