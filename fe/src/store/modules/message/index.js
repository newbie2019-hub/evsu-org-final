import API from '../../base/';
export default {
    namespaced: true,
    state: {
        messages: [],
    },
    getters: {},
    mutations: {
        SET_MESSAGES(state, data) {
            state.messages = data;
        },
    },
    actions: {
        async getMessages({ commit }, { page, sort }) {
            const res = await API.get(`/message?page=${page}&sort=${sort}`)
                .then((res) => {
                    commit('SET_MESSAGES', res.data);
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