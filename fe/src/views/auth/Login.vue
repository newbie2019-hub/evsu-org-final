<template>
 <div>
  <div class="hero ">
   <div class="d-flex justify-content-center align-items-center h-100">
    <div class="col-10 col-sm-10 col-md-6 col-lg-4 col-xl-4">
     <div class="card p-5">
      <h4 class="mb-3 mt-2">Organization Portal</h4>
      <p class="mb-4">
       <small>Welcome! Please fill in your email and password to sign-in.</small>
      </p>
      <div class="form-floating mb-3">
       <input v-model="data.email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" />
       <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
       <input @keypress.enter="login" v-model="data.password" type="password" class="form-control" id="floatingPassword" placeholder="Password" />
       <label for="floatingPassword">Password</label>
      </div>
      <div class="form-check form-switch mt-2">
       <input v-model="adminlogin" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" />
       <label class="form-check-label" for="flexSwitchCheckDefault">Admin Login</label>
      </div>
      <div class="d-grid mt-4">
       <button href="" v-on:click.prevent="login" class="btn btn-primary btn-100" :disabled="isLoading">
        {{ isLoading ? 'Please wait ...' : 'Login' }}
        <i class="bi bi-arrow-right-circle"></i>
       </button>
       <router-link to="/register" type="button" class="text-decoration-none mt-2" v-b-modal.modal-1
        ><small><span class="text-dark">Don't have an account?</span> Sign Up here.</small></router-link
       >
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</template>
<script>
 import { mapActions } from 'vuex';
 export default {
  data() {
   return {
    data: {
     email: '',
     password: '',
    },
    adminlogin: false,
   };
  },
  mounted() {
   document.title = 'Please Login';
  },
  methods: {
   ...mapActions('auth', ['loginAccount', 'loginUserAccount']),
   async login() {
    this.isLoading = true;
    if (this.adminlogin) {
     await this.loginAccount(this.data).then((res) => {
      if (res.status == 200) {
       this.$toast.success('Welcome, Admin!');
       this.$router.push('/dashboard/colleges');
      } else {
       this.$toast.error('Invalid Credentials');
      }
     });
    } else {
     await this.loginUserAccount(this.data).then((res) => {
      if (res.status == 200) {
       this.$router.push('/user/members');
       this.$toast.success(`Welcome, ${res.data.user.email}`);
      } else if (res.status == 403) {
       this.$toast.error('Your account is still pending for approval');
      } else {
       this.$toast.error('Invalid Credentials');
      }
     });
    }
    this.isLoading = false;
   },
  },
 };
</script>
<style scoped>
 .hero {
  height: 100vh;
  background: linear-gradient(to right, rgba(26, 26, 26, 0.644), rgba(37, 2, 2, 0.74)), url('~@/assets/images/bg-hero.jpg');
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  position: absolute;
  width: 100%;
 }
 .form-control:focus {
  box-shadow: 0 0 0 0.1rem rgb(13 110 253 / 25%) !important;
 }
 .register-button {
  position: absolute;
  right: 12%;
  top: 5%;
 }
 .btn-register {
  color: black;
  border-bottom: 0px solid #000;
  transition: all 250ms ease;
 }
 .btn-register:hover {
  color: rgb(55, 137, 214);
 }
</style>
