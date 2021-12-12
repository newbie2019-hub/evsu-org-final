import API from '../../base/'

export default {
  namespaced: true,
  state: {
    courses: [],
    allcourses: [],
  },
  getters: {
    
  },
  mutations: {
    SET_ALL_COURSES(state, data) {
      state.allcourses = data
    },
    SET_COURSES(state, data) {
      state.courses = data
    },
    UPDATE_COURSE(state, data) {
      for(let i = 0; i < state.courses.data.length; i++){
        if(state.courses.data[i].id == data.id){
         state.courses.data[i].course = data.course
         state.courses.data[i].abbreviation = data.abbreviation
        }
       }
    }
  },
  actions: {
    async allCourses({commit}){
      const res = await API.get(`/admin/courses/all`).then(res => {
        commit('SET_ALL_COURSES', res.data)
        return res;
      }).catch(err => {
        return err.response
      })
  
      return res;
     },
    async getCourses({commit}, {page, sort}){
      const res = await API.get(`/admin/courses?page=${page}&sort=${sort}`).then(res => {
        commit('SET_COURSES', res.data)
        return res;
      }).catch(err => {
        return err.response
      })
  
      return res;
     },
     async saveCourse({commit}, payload){
       const res = await API.post('/admin/courses', payload).then(res => {
         return res;
       }).catch(err => {
         return err.response
       })
  
       return res;
     },
     async updateCourse({commit}, payload){
       const res = await API.put(`/admin/courses/${payload.id}`, payload).then(res => {
         commit('UPDATE_COURSE', payload);
         return res;
       }).catch(err => {
         return err.response
       })
  
       return res;
     },
     async deleteCourse({commit}, payload){
       const res = await API.delete(`/admin/courses/${payload.id}`).then(res => {
         return res;
       }).catch(err => {
         return err.response
       })
  
       return res;
     },
  
      /** END OF ACTION */
  },
}