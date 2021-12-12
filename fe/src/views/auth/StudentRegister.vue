<template>
 <div>
  <div class="hero">
   <div class="d-flex justify-content-center align-items-center h-100">
    <div class="col-10 col-sm-10 col-md-6 col-lg-5 col-xl-4">
     <div class="card p-5">
      <h4 class="mb-2 mt-2">Register</h4>
      <p class="mb-4">
       <small>Hi, please fill in all forms to sign-up.</small>
      </p>
      <div v-if="step === 1">
       <h6 class="mb-3">
        <small>Step 1: Your Login Credentials</small>
       </h6>
       <div class="form-floating mb-3">
        <input v-model="data.student_id" type="text" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" />
        <label for="floatingInput">Student Number</label>
       </div>
       <div class="form-floating mb-3">
        <input v-model="data.email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" />
        <label for="floatingInput">Email address</label>
       </div>
       <div class="form-floating">
        <input v-model="data.password" type="password" class="form-control mb-3" id="floatingPassword" placeholder="Password" />
        <label for="floatingPassword">Password</label>
       </div>
       <div class="form-floating">
        <select v-model="data.type" class="form-select">
         <option disabled v-text="disabledOption4"></option>
         <option value="admin">Org-Admin</option>
         <option value="member">Org-Member</option>
        </select>
        <label>Account Type</label>
       </div>
       <div class="d-flex justify-content-center mt-4">
        <button href="" class="btn btn-primary px-4 me-3" v-on:click="returnLogin">
         Return
        </button>
        <button href="" class="btn btn-success px-4" v-on:click="step1" :disabled="isLoading">
         Next
        </button>
       </div>
      </div>
      <div v-if="step === 2">
       <h6 class="mb-3">
        <small>Step 2: Your Information</small>
       </h6>
       <div class="form-floating mb-3">
        <input v-model="data.first_name" type="text" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" />
        <label for="floatingInput">First Name</label>
       </div>
       <div class="form-floating mb-3">
        <input v-model="data.middle_name" type="text" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" />
        <label for="floatingInput">Middle Name (Optional)</label>
       </div>
       <div class="form-floating mb-3">
        <input v-model="data.last_name" type="text" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" />
        <label for="floatingInput">Last Name</label>
       </div>
       <div class="form-floating mb-3">
        <select v-model="data.course_id" class="form-select">
         <option disabled value="">Select a course</option>
         <option :value="course.id" v-for="(course, i) in allcourses" :key="i">{{ course.course }}</option>
        </select>
        <label>Course</label>
       </div>
       <div class="d-flex justify-content-center mt-4">
        <button href="" class="btn btn-primary px-2 me-3" v-on:click="prev">
         Previous
        </button>
        <button href="" class="btn btn-success px-4" v-on:click="step2">
         Next
        </button>
       </div>
      </div>
      <div v-if="step === 3">
       <h6 class="mb-3">
        <small>Step 3: Tell us more about yourself</small>
       </h6>
       <div class="form-floating mb-3">
        <input v-model="data.age" type="number" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off" disabled />
        <label for="floatingInput">Age</label>
       </div>
       <div class="form-floating mb-3">
        <date-picker v-model="data.birthday" value-type="format" format="YYYY-MM-DD" placeholder="Date of Birth " class="w-100" autocomplete="off"></date-picker>
       </div>
       <div class="form-floating mb-3">
        <select v-model="data.gender" class="form-select">
         <option disabled value="" v-text="disabledOption"></option>
         <option value="Male">Male</option>
         <option value="Female">Female</option>
        </select>
        <label>Gender</label>
       </div>
       <label for="" class="mt-2">Contact</label>
       <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">+63</span>
        <input v-model="data.contact" type="number" class="form-control" placeholder="9366036099" aria-label="9366036099" aria-describedby="basic-addon1" />
       </div>
       <div class="d-flex justify-content-center mt-4">
        <button href="" class="btn btn-primary px-2 me-3" v-on:click="prev">
         Previous
        </button>
        <button href="" class="btn btn-success px-4" v-on:click="step3">
         Next
        </button>
       </div>
      </div>
      <div v-if="step === 4">
       <h6 class="mb-3">
        <small>Final Step: Your Education</small>
       </h6>
       <div class="mb-3">
        <label>Upload Image</label>
        <VueFileAgent
         ref="vueFileAgent"
         @select="filesSelected($event)"
         :multiple="false"
         :maxSize="'3MB'"
         :deletable="true"
         :accept="'image/*,'"
         :theme="'list'"
         @beforedelete="onBeforeDelete($event)"
         @delete="fileDeleted($event)"
         :errorText="{
          type: 'Invalid file type. Only image file is allowed',
          size: 'Image should not exceed 3MB in size',
         }"
         v-model="fileRecords"
        ></VueFileAgent>
       </div>
       <div class="form-floating mb-3">
        <select v-model="data.year_level" class="form-select">
         <option disabled value="" v-text="disabledOption1"></option>
         <option value="I">Year Level - I</option>
         <option value="II">Year Level - II</option>
         <option value="III">Year Level - III</option>
         <option value="IV">Year Level - IV</option>
        </select>
        <label>Year Level</label>
       </div>
       <div class="form-floating mb-3">
        <date-picker v-model="data.academic_year" value-type="format" range type="year" format="YYYY" placeholder="Select academic year" class="w-100" autocomplete="off"></date-picker>
       </div>
       <div class="form-floating mb-3">
        <select v-model="data.section_id" class="form-select">
         <option disabled value="" v-text="disabledOption2"></option>
         <option :value="sec.id" v-for="(sec, i) in filteredSection" :key="i">{{ sec.section }}</option>
        </select>
        <label>Section</label>
       </div>
       <div class="form-floating mb-3">
        <select v-model="data.organization_id" class="form-select">
         <option disabled value="" v-text="disabledOption3"></option>
         <option :value="org.id" v-for="(org, i) in allorganizations" :key="i"
          >{{ org.organization }} - <span class="text-muted">{{ org.abbreviation }}</span></option
         >
        </select>
        <label>Organization</label>
       </div>
       <div class="d-flex justify-content-center mt-4">
        <button href="" class="btn btn-primary px-2 me-3" v-on:click="prev">
         Previous
        </button>
        <button href="" class="btn btn-success px-2" v-on:click="register" :disabled="isLoading">
         Register
        </button>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</template>
<script>
 import { mapActions, mapState } from 'vuex';
 export default {
  data() {
   return {
    step: 1,
    data: {
     email: '',
     password: '',
     first_name: '',
     middle_name: '',
     last_name: '',
     age: '',
     birthday: '',
     gender: '',
     contact: '',
     year_level: '',
     academic_year: [],
     acad_year: '',
     student_id: '',
     section_id: '',
     organization_id: '',
     course_id: '',
     type: '',
    },
    isLoading: false,
    fileRecords: [],
    fileRecordsForUpload: [],
   };
  },
  props: {
   disabledOption: {
    type: String,
    default: 'Select your gender',
   },
   disabledOption1: {
    type: String,
    default: 'Select year level',
   },
   disabledOption2: {
    type: String,
    default: 'Select section',
   },
   disabledOption3: {
    type: String,
    default: 'Select organization',
   },
   disabledOption4: {
    type: String,
    default: 'Select account type',
   },
  },
  async mounted() {
   document.title = 'Please Login';
   await this.$store.dispatch('sections/allSections');
   await this.$store.dispatch('organizations/allOrganizations');
   await this.$store.dispatch('courses/allCourses');
  },
  computed: {
   ...mapState('sections', ['allsections']),
   ...mapState('organizations', ['allorganizations']),
   ...mapState('courses', ['allcourses']),
   filteredSection() {
    return this.allsections.filter((section) => {
     return section.year_level === this.data.year_level;
    });
   },
  },
  methods: {
   ...mapActions('auth', ['createAccount', 'emailValidate']),
   filesSelected: function(fileRecordsNewlySelected) {
    var validFileRecords = fileRecordsNewlySelected.filter((fileRecord) => !fileRecord.error);
    this.fileRecordsForUpload = this.fileRecordsForUpload.concat(validFileRecords);
   },
   fileDeleted: function(fileRecord) {
    var i = this.fileRecordsForUpload.indexOf(fileRecord);
    if (i !== -1) {
     this.fileRecordsForUpload.splice(i, 1);
    }
   },
   onBeforeDelete: function(fileRecord) {
    var i = this.fileRecordsForUpload.indexOf(fileRecord);
    if (i !== -1) {
     this.fileRecordsForUpload.splice(i, 1);
     var k = this.fileRecords.indexOf(fileRecord);
     if (k !== -1) this.fileRecords.splice(k, 1);
    }
   },
   disabledDate(date) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    return date >= new Date('2002-01-01');
   },
   async step1() {
    var password_val = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if (this.data.student_id == '') return this.$toast.error('Student ID is required');
    if (this.data.email == '') return this.$toast.error('Email is required');
    if (this.data.password == '') return this.$toast.error('Password is required');
    if (this.data.type == 0) return this.$toast.error('Account Type is required');
    this.isLoading = true;
    const { status, data } = await this.emailValidate(this.data);
    if (status == 200) {
     if (this.data.password.match(password_val)) {
      this.step++;
     } else {
      this.$toast.error('Password must be 8 characters long and contain one lowercase letter, one uppercase letter and one number.');
      this.isLoading = false;
     }
    } else {
     this.$toast.error(data.errors.email[0]);
    }
    this.isLoading = false;
   },
   step2() {
    if (this.data.first_name == '') return this.$toast.error('First name is required');
    if (this.data.last_name == '') return this.$toast.error('Last name is required');
    this.step++;
   },
   step3() {
    var contactval = /^((9)(|\d{9,9}))$/gm;
    if (this.data.age == '') return this.$toast.error('Age is required');
    if (this.data.birthday == '') return this.$toast.error('Birthday is required');
    if (this.data.gender == 0) return this.$toast.error('Gender is required');
    if (this.data.contact == '') return this.$toast.error('Contact is required');
    if (this.data.contact.match(contactval)) {
     var string = '63';
     var number = string + this.data.contact;
     this.data.contact = number;
     this.step++;
    } else {
     this.$toast.error('Contact must be a valid number and not contain any letters or special characters');
    }
   },
   async register() {
    if (this.data.academic_year == '') return this.$toast.error('Academic Year is required');
    if (this.fileRecordsForUpload.length == 0) return this.$toast.error('Please include an image');
    if (this.data.year_level == 0) return this.$toast.error('Year level is required');
    if (this.data.section_id == 0) return this.$toast.error('Section is required');
    if (this.data.organization_id == 0) return this.$toast.error('Organization is required');
    this.data.academic_year[1] = this.data.academic_year[1].toString().substring(2);
    this.data.acad_year = this.data.academic_year.join('-');

    if (this.fileRecordsForUpload.length > 0) {
     const img = await this.$refs.vueFileAgent.upload('http://be.evsu-organization-system.com/api/uploadImage', { 'X-Requested-With': 'XMLHttpRequest' }, this.fileRecordsForUpload);
     this.data.image = img[0].data;
    }

    this.isLoading = true;
    const { data, status } = await this.createAccount(this.data);
    this.checkStatus(data, status, 'register', '', '');
    this.$router.push('/');
   },
   prev() {
    this.step--;
   },
   returnLogin() {
    this.$router.push('/');
   },
   closeModal() {
    this.$bvModal.hide(this.modalId);
   },
  },
  watch: {
   'data.birthday': function() {
    if (this.data.birthday == '' || this.data.birthday == null) return (this.data.age = '');
    var date2 = new Date(this.data.birthday);
    var date1 = new Date();
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24 * 365));
    this.data.age = diffDays - 1;
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
</style>
