<template>
 <div>
  <div class="container pt-5">
   <div class="row ">
    <h5 class="text-primary">Payment Section</h5>
    <p class="text-muted">Organizational Fees are listed below</p>
    <div class="col-12 col-sm-11 col-md-12 col-lg-11 col-xl-11 mt-4">
     <div class="card p-5">
      <div class="d-flex justify-content-end">
       <button v-if="user.userinfo.type == 'admin'" class="btn btn-primary" v-on:click.prevent="$bvModal.show('addPaymentModal')"><i class="bi bi-node-plus me-2"></i>Add Payment</button>
      </div>
      <h5 class="text-center" v-if="payments.data.length == 0">No payment record found</h5>
      <div class="table-responsive mt-4" v-if="payments.data.length > 0">
       <table class="table table-striped table-hover">
        <caption>
         Showing
         {{
          payments.from
         }}
         to
         {{
          payments.to
         }}
         out of
         {{
          payments.total
         }}
         data
        </caption>
        <thead>
         <tr>
          <th scope="col">ID</th>
          <th class="cursor-pointer" v-on:click.prevent="sort = sort == 'asc' ? 'desc' : 'asc'">Payment For <i class="bi" :class="sort == 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short'"></i></th>
          <th scope="col">User</th>
          <th scope="col">Amount</th>
          <th scope="col">Status</th>
          <th scope="col" v-if="user.userinfo.type == 'admin'">Actions</th>
         </tr>
        </thead>
        <tbody>
         <tr v-for="(payment, i) in payments.data" :key="i">
          <td scope="row">{{ i + payments.from }}</td>
          <td>{{ payment.payment_for }}</td>
          <td>{{ payment.user.userinfo.first_name }} {{ payment.user.userinfo.last_name }}</td>
          <td>{{ formatCurrency(payment.amount) }}</td>
          <td>{{ payment.status }}</td>
          <td v-if="user.userinfo.type == 'admin'">
           <div class="d-flex">
            <a
             v-on:click.prevent="
              data = { ...payment };
              $bvModal.show('updatePaymentModal');
             "
             href=""
             class="btn btn-primary btn-sm me-1 rounded-pill"
             ><i class="bi bi-pencil"></i
            ></a>
            <a
             v-on:click.prevent="
              delete_data.id = payment.id;
              $bvModal.show('deletePaymentModal');
             "
             href=""
             class="btn btn-danger btn-sm rounded-pill"
             ><i class="bi bi-trash"></i
            ></a>
           </div>
          </td>
         </tr>
        </tbody>
       </table>
       <div class="row mt-3" v-if="payments.data">
        <pagination :showDisabled="true" :align="'right'" :data="payments" @pagination-change-page="getPayments">
         <span slot="prev-nav">&laquo;</span>
         <span slot="next-nav">&raquo;</span>
        </pagination>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>

  <b-modal id="addPaymentModal" centered title="Add Payment">
   <div class="row pe-4 ps-4 pt-1 pb-2">
    <div class="col">
     <label class="mt-2" for="paymentfor">Select Student</label>
     <br />
     <small>CTRL + click on student name to select multiple user</small>
     <select v-model="data.user_id" class="form-select" size="3" multiple>
      <option v-for="(stud, i) in allmembers" :key="i" :value="stud.id">{{ stud.userinfo.first_name }} {{ stud.userinfo.last_name }}</option>
     </select>
     <label class="mt-2" for="paymentfor">Payment For</label>
     <textarea v-model="data.payment_for" id="paymentfor" type="text" class="form-control" placeholder="" aria-label="Payment For"></textarea>
     <label class="mt-2" for="amount">Amount</label>
     <input v-model="data.amount" id="amount" type="number" class="form-control" placeholder="" aria-label="Amount" />
     <label class="mt-2" for="status">Status</label>
     <input v-model="data.status" id="status" type="text" class="form-control" placeholder="" aria-label="Status" />
    </div>
   </div>
   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading"> Cancel </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="savePayment" :disabled="isLoading">
     Save
    </b-button>
   </template>
  </b-modal>

  <b-modal id="updatePaymentModal" centered title="Update Payment">
   <div class="row pe-4 ps-4 pt-1 pb-2">
    <div class="col">
     <label class="mt-2" for="remarks">Payment For</label>
     <textarea v-model="data.payment_for" id="remarks" type="text" class="form-control" placeholder="" aria-label="What"></textarea>

     <label class="mt-2" for="amount">Amount</label>
     <input v-model="data.amount" id="amount" type="number" class="form-control" placeholder="" aria-label="Amount" />
     <label class="mt-2" for="status">Status</label>
     <input v-model="data.status" id="status" type="text" class="form-control" placeholder="" aria-label="Status" />
    </div>
   </div>
   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading"> Cancel </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="updatePayment" :disabled="isLoading">
     Update
    </b-button>
   </template>
  </b-modal>

  <b-modal id="deletePaymentModal" centered title="Confirm Delete">
   <p>Are you sure you want to delete?</p>
   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading"> Cancel </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="deletePayment" :disabled="isLoading">
     Delete
    </b-button>
   </template>
  </b-modal>
 </div>
</template>
<script>
 import { mapState } from 'vuex';
 export default {
  data() {
   return {
    data: {
     user_id: [],
     payment_for: '',
     amount: '',
     status: '',
    },
    delete_data: {
     id: '',
    },
    sort: 'asc',
   };
  },
  async mounted() {
   await this.$store.dispatch('auth/checkUser');
   document.title = 'Payment Records';
   await this.$store.dispatch('members/allMembers');
   this.getPayments();
   this.$root.$on('bv::modal::show', (modalId) => {
    this.modalId = modalId.componentId;
   });
   this.$root.$on('bv::modal::hide', (modalId) => {
    this.data.user_id = '';
    this.data.payment_for = '';
    this.data.amount = '';
    this.data.status = '';
   });
  },
  computed: {
   ...mapState('payment', ['payments']),
   ...mapState('auth', ['user']),
   ...mapState('members', ['allmembers']),
  },
  methods: {
   async getPayments(page = 1) {
    await this.$store.dispatch('payment/getPayments', { page: page, sort: this.sort });
   },
   async savePayment() {
    if (this.data.user_id == '') return this.$toast.error('User is required');
    if (this.data.payment_for == '') return this.$toast.error('Payment for is required');
    if (this.data.amount == '') return this.$toast.error('Amount is required');
    if (this.data.status == '') return this.$toast.error('Status is required');

    this.isLoading = true;
    const { data, status } = await this.$store.dispatch('payment/savePayment', this.data);
    this.checkStatus(data, status, '', 'payment/getPayments');
   },
   async updatePayment() {
    if (this.data.user_id == '') return this.$toast.error('User is required');
    if (this.data.payment_for == '') return this.$toast.error('Payment for is required');
    if (this.data.amount == '') return this.$toast.error('Amount is required');
    if (this.data.status == '') return this.$toast.error('Status is required');

    this.isLoading = true;
    const { data, status } = await this.$store.dispatch('payment/updatePayment', this.data);
    this.checkStatus(data, status, 'update');
   },
   async deletePayment() {
    this.isLoading = true;
    const { data, status } = await this.$store.dispatch('payment/deletePayment', this.delete_data);
    this.checkStatus(data, status, '', 'payment/getPayments');
   },
   closeModal() {
    this.$bvModal.hide(this.modalId);
   },
   formatCurrency(data) {
    var formatter = new Intl.NumberFormat('en-US', {
     style: 'currency',
     currency: 'PHP',
    });
    return formatter.format(data);
   },
  },
  watch: {
   sort() {
    this.getPayments();
   },
  },
 };
</script>
