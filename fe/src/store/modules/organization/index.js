import API from '../../base/';

export default {
    namespaced: true,
    state: {
        organizations: [],
        coursetype: [],
        valuestype: [],
        allorganizations: [],
    },
    getters: {},
    mutations: {
        SET_ALL_ORGANIZATIONS(state, data) {
            state.allorganizations = data;
        },
        SET_ORGANIZATIONS(state, data) {
            state.organizations = data;
        },
        SET_ORGANIZATIONS1(state, data) {
            state.coursetype = data;
        },
        SET_ORGANIZATIONS2(state, data) {
            state.valuestype = data;
        },
        UPDATE_ORGANIZATION(state, data) {
            for (let i = 0; i < state.organizations.data.length; i++) {
                if (state.organizations.data[i].id == data.id) {
                    state.organizations.data[i].organization = data.organization;
                    state.organizations.data[i].abbreviation = data.abbreviation;
                    state.organizations.data[i].organization_service_id = data.orgservice;
                }
            }
        },
        UPDATE_ORGANIZATION1(state, data) {
            for (let i = 0; i < state.courstype.data.length; i++) {
                if (state.courstype.data[i].id == data.id) {
                    state.courstype.data[i].organization = data.organization;
                    state.courstype.data[i].abbreviation = data.abbreviation;
                    state.courstype.data[i].organization_service_id = data.orgservice;
                }
            }
        },
        UPDATE_ORGANIZATION2(state, data) {
            for (let i = 0; i < state.valuestype.data.length; i++) {
                if (state.valuestype.data[i].id == data.id) {
                    state.valuestype.data[i].organization = data.organization;
                    state.valuestype.data[i].abbreviation = data.abbreviation;
                    state.valuestype.data[i].organization_service_id = data.orgservice;
                }
            }
        },
    },
    actions: {
        async allOrganizations({ commit }) {
            const res = await API.get(`/admin/organization/all`)
                .then((res) => {
                    commit('SET_ALL_ORGANIZATIONS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async getOrganizations({ commit }, { page, sort }) {
            const res = await API.get(`/admin/organization?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_ORGANIZATIONS', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async getOrganizations1({ commit }, { page, sort }) {
            const res = await API.get(`/admin/organization/coursetype?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_ORGANIZATIONS1', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async getOrganizations2({ commit }, { page, sort }) {
            const res = await API.get(`/admin/organization/valuestype?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_ORGANIZATIONS2', res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async searchOrganizations({ commit }, { page, sort, data }) {
            const res = await API.post(`/admin/search/organization/?page=${page}&sort=${sort}`, data)
                .then((res) => {
                    commit(['SET_ORGANIZATIONS', 'SET_ORGANIZATIONS1', 'SET_ORGANIZATIONS2'], res.data);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async saveOrganization({ commit }, payload) {
            const res = await API.post('/admin/organization', payload)
                .then((res) => {
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async updateOrganization({ commit }, payload) {
            const res = await API.put(`/admin/organization/${payload.id}`, payload)
                .then((res) => {
                    commit('UPDATE_ORGANIZATION', payload);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async updateOrganization1({ commit }, payload) {
            const res = await API.put(`/admin/organization/${payload.id}`, payload)
                .then((res) => {
                    commit('UPDATE_ORGANIZATION1', payload);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async updateOrganization2({ commit }, payload) {
            const res = await API.put(`/admin/organization/${payload.id}`, payload)
                .then((res) => {
                    commit('UPDATE_ORGANIZATION2', payload);
                    return res;
                })
                .catch((err) => {
                    return err.response;
                });

            return res;
        },
        async deleteOrganization({ commit }, payload) {
            const res = await API.delete(`/admin/organization/${payload.id}`)
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