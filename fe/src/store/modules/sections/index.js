import API from '../../base/'

export default {
  namespaced: true,
  state: {
    sections: [],
    allsections: [],
  },
  getters: {
    
  },
  mutations: {
    SET_ALL_SECTIONS(state, data) {
      state.allsections = data
    },
    SET_SECTIONS(state, data) {
      state.sections = data
    },
    UPDATE_SECTION(state, data) {
      for(let i = 0; i < state.sections.data.length; i++){
        if(state.sections.data[i].id == data.id){
         state.sections.data[i].section = data.section
         state.sections.data[i].year_level = data.year_level
        }
       }
    }
  },
  actions: {
    async allSections({commit}){
      const res = await API.get(`/admin/sections/all`).then(res => {
        commit('SET_ALL_SECTIONS', res.data)
        return res;
      }).catch(err => {
        return err.response
      })
  
      return res;
     },
    async getSections({commit}, {page, sort}){
      const res = await API.get(`/admin/sections?page=${page}&sort=${sort}`).then(res => {
        commit('SET_SECTIONS', res.data)
        return res;
      }).catch(err => {
        return err.response
      })
  
      return res;
     },
     async saveSection({commit}, payload){
       const res = await API.post('/admin/sections', payload).then(res => {
         return res;
       }).catch(err => {
         return err.response
       })
  
       return res;
     },
     async updateSection({commit}, payload){
       const res = await API.put(`/admin/sections/${payload.id}`, payload).then(res => {
         commit('UPDATE_SECTION', payload);
         return res;
       }).catch(err => {
         return err.response
       })
  
       return res;
     },
     async deleteSection({commit}, payload){
       const res = await API.delete(`/admin/sections/${payload.id}`).then(res => {
         return res;
       }).catch(err => {
         return err.response
       })
  
       return res;
     },
  
      /** END OF ACTION */
  },
}