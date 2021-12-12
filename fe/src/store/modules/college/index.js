import API from '../../base/'

export default {
  namespaced: true,
  state: {
    colleges: [],
    allcolleges: [],
  },
  getters: {
    
  },
  mutations: {
    SET_ALL_COLLEGES(state, data) {
      state.allcolleges = data
    },
    SET_COLLEGES(state, data) {
      state.colleges = data
    },
    UPDATE_COLLEGE(state, data) {
      for(let i = 0; i < state.colleges.data.length; i++){
        if(state.colleges.data[i].id == data.id){
         state.colleges.data[i].college = data.college
         state.colleges.data[i].abbreviation = data.abbreviation
         state.colleges.data[i].mission = data.mission
         state.colleges.data[i].vision = data.vision
        }
       }
    }
  },
  actions: {
   async allColleges({commit}){
    const res = await API.get(`/admin/college/all`).then(res => {
      commit('SET_ALL_COLLEGES', res.data)
      return res;
    }).catch(err => {
      return err.response
    })

    return res;
   },
   async getColleges({commit}, {page, sort}){
    const res = await API.get(`/admin/college?page=${page}&sort=${sort}`).then(res => {
      commit('SET_COLLEGES', res.data)
      return res;
    }).catch(err => {
      return err.response
    })

    return res;
   },
   async saveCollege({commit}, payload){
     const res = await API.post('/admin/college', payload).then(res => {
       return res;
     }).catch(err => {
       return err.response
     })

     return res;
   },
   async updateCollege({commit}, payload){
     const res = await API.put(`/admin/college/${payload.id}`, payload).then(res => {
       commit('UPDATE_COLLEGE', payload);
       return res;
     }).catch(err => {
       return err.response
     })

     return res;
   },
   async deleteCollege({commit}, payload){
     const res = await API.delete(`/admin/college/${payload.id}`).then(res => {
       return res;
     }).catch(err => {
       return err.response
     })

     return res;
   },

    /** END OF ACTION */
  },
}