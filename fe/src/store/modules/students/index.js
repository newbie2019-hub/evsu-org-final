import API from '../../base/';
import Vue from 'vue';

export default {
    namespaced: true,
    state: {
        students: [],
        allstudents: [],
        pending_students: [],
        announcements: [],
        admins: [],
    },
    getters: {},
    mutations: {
        SET_STUDENTS(state, data) {
            state.students = data;
        },
        SET_ADMINS(state, data) {
            state.admins = data;
        },
        SET_ALL_STUDENTS(state, data) {
            state.allstudents = data;
        },
        SET_PENDING_STUDENTS(state, data) {
            state.pending_students = data;
        },
        UPDATE_STUDENT(state, data) {
            for (let i = 0; i < state.students.data.length; i++) {
                if (state.students.data[i].id == data.id) {
                    Vue.set(state.students.data, i, data);
                }
            }
        },
        UPDATE_ANNOUNCEMENT(state, data) {
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
        async searchStudents({ commit }, { page, sort, data }) {
            const res = await API.post(`/admin/search/students?page=${page}&sort=${sort}`, data)
                .then((res) => {
                    commit('SET_STUDENTS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async getStudents({ commit }, { page, sort }) {
            const res = await API.get(`/admin/students?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_STUDENTS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },

        async saveAnnouncement({ commit }, payload) {
            const res = await API.post('/admin/announcement', payload)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async updateAnnouncement({ commit }, payload) {
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
        async getPendingStudents({ commit }, { page, sort }) {
            const res = await API.get(`/admin/pendingstudents?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_PENDING_STUDENTS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async allAdmins({ commit }) {
            const res = await API.get(`/admin/orgadmins`)
                .then((res) => {
                    commit('SET_ADMINS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async saveStudent({ commit }, payload) {
            const res = await API.post('/admin/students', payload)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async updateStudent({ commit }, payload) {
            const res = await API.put(`/admin/students/${payload.id}`, payload)
                .then((res) => {
                    commit('UPDATE_STUDENT', res.data[0]);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async deleteStudent({ commit }, payload) {
            const res = await API.delete(`/admin/students/${payload.id}`)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async approveStudent({ commit }, payload) {
            const res = await API.put(`/admin/approve/${payload.id}`, payload)
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