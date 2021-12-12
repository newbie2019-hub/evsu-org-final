import API from '../../base/'
export default {
  namespaced: true,
  state: {
    payments: [],
  },
  getters: {
    
  },
  mutations: {
    SET_PAYMENTS(state, data) {
      state.payments = data
    },
    UPDATE_PAYMENT(state, data) {
      for(let i = 0; i < state.payments.data.length; i++){
        if(state.payments.data[i].id == data.id){
          state.payments.data[i].payment_for = data.payment_for
          state.payments.data[i].amount = data.amount
          state.payments.data[i].status = data.status
          state.payments.data[i].instructor = data.instructor
        }
       }
    }
  },
  actions: {
    async getPayments({commit}, {page, sort}){
      const res = await API.get(`/user/payments?page=${page}&sort=${sort}`).then(res => {
        commit('SET_PAYMENTS', res.data)
        return res;
      }).catch(err => {
        return err.response
      })
  
      return res;
     },
     async savePayment({commit}, payload){
       const res = await API.post('/user/payments', payload).then(res => {
         return res;
       }).catch(err => {
         return err.response
       })
  
       return res;
     },
     async updatePayment({commit}, payload){
       const res = await API.put(`/user/payments/${payload.id}`, payload).then(res => {
         commit('UPDATE_PAYMENT', payload);
         return res;
       }).catch(err => {
         return err.response
       })
  
       return res;
     },
     async deletePayment({commit}, payload){
       const res = await API.delete(`/user/payments/${payload.id}`).then(res => {
         return res;
       }).catch(err => {
         return err.response
       })
  
       return res;
     },
  
      /** END OF ACTION */
  },
}