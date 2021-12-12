<template>
 <div>
  <div class="container pt-5">
   <div class="row ">
    <h5 class="text-primary">Official Organization Admins</h5>
    <p class="text-muted">Listed below are the approved admins in your organization</p>
    <div class="col-12 col-sm-11 col-md-12 col-lg-11 col-xl-11 mt-4">
     <div class="card p-5">
      <div class="row justify-content-end mt-2">
       <div class="d-block">
        <button class="btn btn-primary" v-on:click.prevent="$bvModal.show('addStudentModal')"><i class="bi bi-node-plus me-2"></i>Add Student</button>
       </div>
       <div class="col-6 col-sm-5 col-md-5 col-lg-4 col-xl-3">
        <div class="input-group  mb-3">
         <input type="text" v-model="search" class="form-control" id="floatingSearchOrg" placeholder="Search here" />
         <button class="btn btn-primary"><i class="bi bi-search"></i></button>
        </div>
       </div>
      </div>
      <h5 class="text-center" v-if="admins.data.length == 0">No member found</h5>
      <div class="table-responsive mt-4" v-if="admins.data.length > 0">
       <table class="table table-striped table-hover">
        <caption>
         Showing
         {{
          admins.from
         }}
         to
         {{
          admins.to
         }}
         out of
         {{
          admins.total
         }}
         data
        </caption>
        <thead>
         <tr>
          <th scope="col">ID</th>
          <th scope="col" class="text-nowrap">Student ID</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Organization</th>
          <th scope="col">Academic Year</th>
          <th scope="col">Action</th>
         </tr>
        </thead>
        <tbody>
         <tr v-for="(stud, i) in admins.data" :key="i">
          <td scope="row">{{ i + admins.from }}</td>
          <td>{{ stud.student_id }}</td>
          <td class="text-nowrap">{{ stud.userinfo.first_name }} {{ stud.userinfo.last_name }}</td>
          <td>{{ stud.email }}</td>
          <td>{{ stud.userinfo.organization.organization }}</td>
          <td>S.Y. {{ stud.userinfo.academic_year }}</td>
          <td>
           <div class="d-flex">
            <a
             v-on:click.prevent="
              update_data = JSON.parse(JSON.stringify(stud));
              $bvModal.show('updateStudentModal');
             "
             href=""
             class="btn btn-primary btn-sm me-1 rounded-pill"
             ><i class="bi bi-pencil"></i
            ></a>
            <a
             v-on:click.prevent="
              delete_data.id = stud.id;
              $bvModal.show('deleteStudentModal');
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
      </div>
     </div>
    </div>
   </div>
  </div>
  <div class="container pt-5">
   <div class="row ">
    <h5 class="text-primary">Official Organization Members</h5>
    <p class="text-muted">Manage officially students registered on the system</p>
    <div class="col-12 col-sm-11 col-md-12 col-lg-11 col-xl-11 mt-4">
     <div class="card p-5">
      <div class="d-flex justify-content-end"></div>
      <h5 class="text-center" v-if="students.data.length == 0">No accounts found</h5>
      <b-skeleton-table :rows="6" :columns="8" :table-props="{ bordered: true, striped: true }" class="mt-4" v-if="initialLoading"></b-skeleton-table>
      <div class="table-responsive mt-4" v-if="students.data.length > 0">
       <table class="table table-striped table-hover">
        <caption>
         Showing
         {{
          students.from
         }}
         to
         {{
          students.to
         }}
         out of
         {{
          students.total
         }}
         data
        </caption>
        <thead>
         <tr>
          <th scope="col">ID</th>
          <th scope="col" class="text-nowrap">Student ID</th>
          <th scope="col">Name</th>
          <th scope="col">Gender</th>
          <th scope="col">Email</th>
          <th scope="col">Academic Year</th>
          <th scope="col">Level</th>
          <th scope="col">Section</th>
          <th scope="col">Organization</th>
          <th scope="col">Action</th>
         </tr>
        </thead>
        <tbody>
         <tr v-for="(stud, i) in students.data" :key="i">
          <td scope="row">{{ i + students.from }}</td>
          <td>{{ stud.student_id }}</td>
          <td class="text-nowrap">
           {{ stud.userinfo.first_name }}
           {{ stud.userinfo.last_name }}
          </td>
          <td>{{ stud.userinfo.gender }}</td>
          <td>{{ stud.email }}</td>
          <td class="text-nowrap">S.Y. {{ stud.userinfo.academic_year }}</td>
          <td class="text-nowrap">Year Level - {{ stud.userinfo.section.year_level }}</td>
          <td class="text-nowrap">
           {{ stud.userinfo.section.section }}
          </td>
          <td class="text-nowrap">
           {{ stud.userinfo.organization.organization }}
          </td>
          <td>
           <div class="d-flex">
            <a
             v-on:click.prevent="
              update_data = JSON.parse(JSON.stringify(stud));
              $bvModal.show('updateStudentModal');
             "
             href=""
             class="btn btn-primary btn-sm me-1 rounded-pill"
             ><i class="bi bi-pencil"></i
            ></a>
            <a
             v-on:click.prevent="
              delete_data.id = stud.id;
              $bvModal.show('deleteStudentModal');
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
      </div>
     </div>
    </div>
   </div>
  </div>

  <div class="container py-5">
   <div class="row ">
    <h5 class="text-primary">Pending Accounts</h5>
    <p class="text-muted">Listed below are the pending admin accounts registered</p>
    <div class="col-12 col-sm-11 col-md-12 col-lg-11 col-xl-11 mt-4">
     <div class="card p-5">
      <h5 class="text-center" v-if="pending_students.data.length == 0">No pending account to approve</h5>
      <div class="table-responsive mt-4" v-if="pending_students.data.length > 0">
       <table class="table table-striped table-hover">
        <caption>
         Showing
         {{
          pending_students.from
         }}
         to
         {{
          pending_students.to
         }}
         out of
         {{
          pending_students.total
         }}
         data
        </caption>
        <thead>
         <tr>
          <th scope="col">ID</th>
          <th scope="col" class="text-nowrap">Student ID</th>
          <th scope="col">Name</th>
          <th scope="col">Gender</th>
          <th scope="col">Email</th>
          <th scope="col">Academic Year</th>
          <th scope="col">Level</th>
          <th scope="col">Course</th>
          <th scope="col">Action</th>
         </tr>
        </thead>
        <tbody>
         <tr v-for="(pending, i) in pending_students.data" :key="i">
          <td scope="row">{{ i + pending_students.from }}</td>
          <td>{{ pending.student_id }}</td>
          <td class="text-nowrap">{{ pending.userinfo.first_name }} {{ pending.userinfo.last_name }}</td>
          <td>{{ pending.userinfo.gender }}</td>
          <td>{{ pending.email }}</td>
          <td class="text-nowrap">S.Y. {{ pending.userinfo.academic_year }}</td>
          <td class="text-nowrap">Year Level - {{ pending.userinfo.section.year_level }}</td>
          <td class="text-nowrap">{{ pending.userinfo.course.course }}</td>
          <td>
           <div class="d-flex">
            <a
             v-on:click.prevent="
              approve_data.id = pending.id;
              $bvModal.show('approveStudentModal');
             "
             href=""
             class="btn btn-success btn-sm me-1 rounded-pill"
             ><i class="bi bi-check2"></i
            ></a>
            <a
             v-on:click.prevent="
              update_data = JSON.parse(JSON.stringify(pending));
              $bvModal.show('viewStudentModal');
             "
             href=""
             class="btn btn-primary btn-sm me-1 rounded-pill"
             ><i class="bi bi-arrows-angle-expand"></i
            ></a>
            <a
             v-on:click.prevent="
              delete_data.id = pending.id;
              $bvModal.show('deleteStudentModal');
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
      </div>
     </div>
    </div>
   </div>
  </div>

  <b-modal id="addStudentModal" scrollable centered title="Add Student">
   <h6>Account Credentials</h6>
   <div class="row pb-2">
    <div class="col-6">
     <label class="mt-2" for="studentid">Student ID</label>
     <input v-model="data.student_id" id="studentid" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="email">Email</label>
     <input v-model="data.email" id="email" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="password">Password</label>
     <input v-model="data.password" id="password" type="password" class="form-control" placeholder="" />
    </div>
   </div>
   <h6 class="mt-2">Personal Info</h6>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="fname">First Name</label>
     <input v-model="data.first_name" id="fname" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="mname">Middle Name</label>
     <input v-model="data.middle_name" id="mname" type="text" class="form-control" placeholder="" />
    </div>
   </div>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="lname">Last Name</label>
     <input v-model="data.last_name" id="lname" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="mname">Gender</label>
     <select v-model="data.gender" id="mname" type="text" class="form-select" placeholder="">
      <option disabled selected>Please select your gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
     </select>
    </div>
   </div>
   <div class="row">
    <div class="col-6">
     <label for="" class="mt-2">Contact</label>
     <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">+63</span>
      <input v-model="data.contact" type="number" class="form-control" placeholder="9366036099" aria-label="9366036099" aria-describedby="basic-addon1" />
     </div>
    </div>
    <div class="col-6">
     <label class="mt-2">Course</label>
     <select v-model="data.course_id" class="form-select">
      <option disabled value="">Select a course</option>
      <option :value="course.id" v-for="(course, i) in allcourses" :key="i">{{ course.course }}</option>
     </select>
    </div>
    <div class="col-6">
     <label class="mt-2" for="type">Type</label>
     <select v-model="data.type" id="type" type="text" class="form-select" placeholder="">
      <option disabled selected>Select an account type</option>
      <option value="admin">Org-Admin</option>
      <option value="member">Org-Member</option>
     </select>
    </div>
   </div>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="yearlevel">Year Level</label>
     <select v-model="data.year_level" class="form-select">
      <option value="I">Year Level - I</option>
      <option value="II">Year Level - II</option>
      <option value="III">Year Level - III</option>
      <option value="IV">Year Level - IV</option>
     </select>
    </div>
    <div class="col-6 mt-4">
     <date-picker v-model="data.academic_year" value-type="format" range type="year" format="YYYY" placeholder="Select academic year" class="w-100" autocomplete="off"></date-picker>
    </div>
    <div class="col-6">
     <label class="mt-2" for="section">Section</label>
     <select v-model="data.section_id" id="section" class="form-select" placeholder="">
      <option v-for="(sec, i) in filteredSection" :key="i" :value="sec.id">{{ sec.section }}</option>
     </select>
    </div>
    <div class="col-6">
     <label class="mt-2" for="organizationid">Organization</label>
     <select v-model="data.organization_id" id="organizationid" class="form-select" placeholder="">
      <option :value="org.id" v-for="(org, i) in allorganizations" :key="i"
       >{{ org.organization }} - <span class="text-muted">{{ org.abbreviation }}</span></option
      >
     </select>
    </div>
   </div>

   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading">
     Cancel
    </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="saveStudent" :disabled="isLoading">
     Save
    </b-button>
   </template>
  </b-modal>

  <b-modal id="updateStudentModal" scrollable centered title="Update Student">
   <h6>Account Credentials</h6>
   <div class="row pb-2">
    <div class="col-6">
     <label class="mt-2" for="studentid">Student ID</label>
     <input v-model="update_data.student_id" id="studentid" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="email">Email</label>
     <input v-model="update_data.email" id="email" type="text" class="form-control" placeholder="" />
    </div>
   </div>
   <h6 class="mt-2">Personal Info</h6>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="fname">First Name</label>
     <input v-model="update_data.userinfo.first_name" id="fname" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="mname">Middle Name</label>
     <input v-model="update_data.userinfo.middle_name" id="mname" type="text" class="form-control" placeholder="" />
    </div>
   </div>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="lname">Last Name</label>
     <input v-model="update_data.userinfo.last_name" id="lname" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="mname">Gender</label>
     <select v-model="update_data.userinfo.gender" id="mname" type="text" class="form-select" placeholder="">
      <option disabled selected>Please select your gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
     </select>
    </div>
   </div>
   <div class="row">
    <div class="col-6">
     <label for="" class="mt-2">Contact</label>
     <div class="input-group mb-3">
      <input v-model="update_data.userinfo.contact" type="number" class="form-control" placeholder="9366036099" aria-label="9366036099" aria-describedby="basic-addon1" />
     </div>
    </div>
    <div class="col-6">
     <label class="mt-2">Course</label>
     <select v-model="update_data.userinfo.course_id" class="form-select">
      <option disabled value="">Select a course</option>
      <option :value="course.id" v-for="(course, i) in allcourses" :key="i">{{ course.course }}</option>
     </select>
    </div>
    <div class="col-6">
     <label class="mt-2" for="type">Type</label>
     <select v-model="update_data.userinfo.type" id="type" type="text" class="form-select" placeholder="">
      <option disabled selected>Select an account type</option>
      <option value="admin">Admin</option>
      <option value="member">Member</option>
     </select>
    </div>
   </div>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="yearlevel">Year Level</label>
     <select v-model="update_data.userinfo.year_level" class="form-select">
      <option value="I">Year Level - I</option>
      <option value="II">Year Level - II</option>
      <option value="III">Year Level - III</option>
      <option value="IV">Year Level - IV</option>
     </select>
    </div>
    <div class="col-6">
     <label class="mt-2" for="section">Section</label>
     <select v-model="update_data.userinfo.section_id" id="section" class="form-select" placeholder="">
      <option :value="sec.id" v-for="(sec, i) in filteredUpdateSection" :key="i">{{ sec.section }}</option>
     </select>
    </div>
    <div class="col-6">
     <label class="mt-2" for="organizationid">Organization</label>
     <select v-model="update_data.userinfo.organization_id" id="organizationid" class="form-select" placeholder="">
      <option :value="org.id" v-for="(org, i) in allorganizations" :key="i"
       >{{ org.organization }} - <span class="text-muted">{{ org.abbreviation }}</span></option
      >
     </select>
    </div>
    <div class="col-6">
     <label class="mt-2">Academic Year</label>
     <input class="form-control" v-model="update_data.userinfo.academic_year" />
    </div>
   </div>
   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading">
     Cancel
    </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="updateStudent" :disabled="isLoading">
     Update
    </b-button>
   </template>
  </b-modal>

  <b-modal id="deleteStudentModal" centered title="Confirm Delete">
   <p>Are you sure you want to delete this student?</p>
   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading">
     Cancel
    </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="deleteStudent" :disabled="isLoading">
     Delete
    </b-button>
   </template>
  </b-modal>

  <b-modal id="viewStudentModal" scrollable centered title="Student Details">
   <h6>Account Credentials</h6>
   <div class="row pb-2">
    <div class="col-6">
     <label class="mt-2" for="studentid">Student ID</label>
     <input disabled v-model="update_data.student_id" id="studentid" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="email">Email</label>
     <input disabled v-model="update_data.email" id="email" type="text" class="form-control" placeholder="" />
    </div>
   </div>
   <h6 class="mt-2">Personal Info</h6>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="fname">First Name</label>
     <input disabled v-model="update_data.userinfo.first_name" id="fname" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="mname">Middle Name</label>
     <input disabled v-model="update_data.userinfo.middle_name" id="mname" type="text" class="form-control" placeholder="" />
    </div>
   </div>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="lname">Last Name</label>
     <input disabled v-model="update_data.userinfo.last_name" id="lname" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2" for="mname">Gender</label>
     <select disabled v-model="update_data.userinfo.gender" id="mname" type="text" class="form-select" placeholder="">
      <option disabled selected>Please select your gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
     </select>
    </div>
   </div>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="contact">Contact</label>
     <input disabled v-model="update_data.userinfo.contact" id="contact" type="text" class="form-control" placeholder="" />
    </div>
    <div class="col-6">
     <label class="mt-2">Course</label>
     <select v-model="update_data.userinfo.course_id" disabled class="form-select">
      <option disabled value="">Select a course</option>
      <option :value="course.id" v-for="(course, i) in allcourses" :key="i">{{ course.course }}</option>
     </select>
    </div>
    <div class="col-6">
     <label class="mt-2" for="type">Type</label>
     <select disabled v-model="update_data.userinfo.type" id="type" type="text" class="form-select" placeholder="">
      <option disabled selected>Select an account type</option>
      <option value="admin">Admin</option>
      <option value="member">Member</option>
     </select>
    </div>

    <div class="col-6 mt-4 pt-3">
     <p class="">S.Y. {{ update_data.userinfo.academic_year }}</p>
    </div>
   </div>
   <div class="row">
    <div class="col-6">
     <label class="mt-2" for="yearlevel">Year Level</label>
     <select disabled v-model="update_data.userinfo.year_level" class="form-select">
      <option value="I">Year Level - I</option>
      <option value="II">Year Level - II</option>
      <option value="III">Year Level - III</option>
      <option value="IV">Year Level - IV</option>
     </select>
    </div>
    <div class="col-6">
     <label class="mt-2" for="section">Section</label>
     <select disabled v-model="update_data.userinfo.section_id" id="section" class="form-select" placeholder="">
      <option :value="sec.id" v-for="(sec, i) in filteredUpdateSection" :key="i">{{ sec.section }}</option>
     </select>
    </div>
   </div>
   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading"> Close </b-button>
   </template>
  </b-modal>

  <b-modal id="approveStudentModal" centered title="Confirm Approve">
   <p>Are you sure you want to appprove this account?</p>
   <template #modal-footer="{cancel}">
    <b-button variant="danger" size="sm" @click="cancel()" :disabled="isLoading"> No </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="approveStudent" :disabled="isLoading">
     Yes, approve
    </b-button>
   </template>
  </b-modal>
 </div>
</template>
<script>
 import { mapState } from 'vuex';
 const _ = require('lodash');

 export default {
  data() {
   return {
    data: {
     first_name: '',
     middle_name: '',
     last_name: '',
     gender: '',
     course_id: '',
     contact: '',
     type: '',
     section_id: '',
     year_level: 'I',
     organization_id: '',
     student_id: '',
     account_status: 'approved',
     email: '',
     password: '',
     academic_year: [],
     acad_year: '',
    },
    update_data: {
     userinfo: '',
    },
    approve_data: {
     id: '',
    },
    delete_data: {
     id: '',
    },
    sort: 'asc',
    search: '',
   };
  },
  async mounted() {
   this.initialLoading = true;
   await this.$store.dispatch('auth/checkAdminUser');
   await this.$store.dispatch('organizations/allOrganizations');
   await this.$store.dispatch('sections/allSections');
   await this.$store.dispatch('courses/allCourses');
   this.getStudents();
   this.getPendingStudents();
   this.getAdmins();
   this.$root.$on('bv::modal::show', (modalId) => {
    this.modalId = modalId.componentId;
   });
   this.$root.$on('bv::modal::hide', (modalId) => {
    this.data.college_id = '';
    this.data.student_id = '';
    this.data.email = '';
    this.data.password = '';
    this.data.first_name = '';
    this.data.middle_name = '';
    this.data.last_name = '';
    this.data.gender = '';
    this.data.year_level = '';
   });
   this.initialLoading = false;
  },
  watch: {
   search() {
    this.debouncedStudentsSearch();
   },
   sort() {
    this.getStudents();
    this.getAdmins();
    this.getPendingStudents();
   },
  },
  created: function() {
   this.debouncedStudentsSearch = _.debounce(this.studentSearch, 800);
  },
  computed: {
   ...mapState('college', ['allcolleges']),
   ...mapState('students', ['students', 'pending_students', 'admins']),
   ...mapState('sections', ['allsections']),
   ...mapState('organizations', ['allorganizations']),
   ...mapState('courses', ['allcourses']),
   filteredSection() {
    return this.allsections.filter((section) => {
     return section.year_level === this.data.year_level;
    });
   },
   filteredUpdateSection() {
    return this.allsections.filter((section) => {
     return section.year_level === this.update_data.userinfo.year_level;
    });
   },
  },
  methods: {
   async studentSearch(page = 1) {
    let data = {
     search: this.search,
    };
    this.isSearching = true;
    await this.$store.dispatch('students/searchStudents', { page: page, sort: this.sort, data: data });
    this.isSearching = false;
   },
   async getStudents(page = 1) {
    await this.$store.dispatch('students/getStudents', {
     page: page,
     sort: this.sort,
    });
   },
   async getAdmins(page = 1) {
    await this.$store.dispatch('students/allAdmins', { page: page, sort: this.sort });
   },
   async getPendingStudents(page = 1) {
    await this.$store.dispatch('students/getPendingStudents', { page: page, sort: this.sort });
   },
   async approveStudent(page = 1) {
    this.isLoading = true;
    const { data, status } = await this.$store.dispatch('students/approveStudent', this.approve_data);
    this.checkStatus(data, status, 'update', 'students/allAdmins', 'students/getPendingStudents');
    this.getStudents();
    await this.$store.dispatch('students/getPendingStudents', { page: page, sort: this.sort });
   },
   async saveStudent() {
    var contactval = /^((9)(|\d{9,9}))$/gm;
    if (this.data.student_id == '') return this.$toast.error('Student ID is required');
    if (this.data.section_id == '') return this.$toast.error('Section is required');
    if (this.data.course_id == '') return this.$toast.error('Course is required');
    if (this.data.email == '') return this.$toast.error('Email is required');
    if (this.data.password == '') return this.$toast.error('Password is required');
    if (this.data.first_name.trim() == '') return this.$toast.error('First Name is required');
    if (this.data.middle_name.trim() == '') return this.$toast.error('Middle Name is required');
    if (this.data.last_name.trim() == '') return this.$toast.error('Last Name is required');
    if (this.data.gender == '') return this.$toast.error('Gender is required');
    if (this.data.contact == '') return this.$toast.error('Contact is required');
    if (this.data.type == '') return this.$toast.error('Account Type is required');
    if (this.data.year_level == '') return this.$toast.error('Year Level is required');
    if (this.data.organization_id == '') return this.$toast.error('Organization is required');
    if (this.data.academic_year == '') return this.$toast.error('Academic year is required');
    this.data.academic_year[1] = this.data.academic_year[1].toString().substring(2);
    this.data.acad_year = this.data.academic_year.join('-');
    if (this.data.contact.match(contactval)) {
     var string = '63';
     var number = string + this.data.contact;
     this.data.contact = number;
     this.isLoading = true;
     const { data, status } = await this.$store.dispatch('students/saveStudent', this.data);
     if (status == 200) {
      this.checkStatus(data, status, '', 'students/getStudents', 'students/allAdmins');
     } else {
      this.checkStatus(data, status, '', 'students/getStudents', 'students/allAdmins');
     }
    } else {
     this.$toast.error('Contact must be a valid number and not contain any letters or special characters');
    }
   },
   async updateStudent() {
    var contactval = /^((639)(|\d{9,9}))$/gm;
    this.update_data.userinfo.acad_year = this.update_data.userinfo.academic_year;
    if (this.update_data.userinfo.academic_year.trim() == '') return this.$toast.error('Academic year is required');
    if (this.update_data.student_id == '') return this.$toast.error('Student ID is required');
    if (this.update_data.email == '') return this.$toast.error('Email is required');
    if (this.update_data.password == '') return this.$toast.error('Password is required');
    if (this.update_data.userinfo.first_name.trim() == '') return this.$toast.error('First Name is required');
    if (this.update_data.userinfo.middle_name.trim() == '') return this.$toast.error('Middle Name is required');
    if (this.update_data.userinfo.last_name.trim() == '') return this.$toast.error('Last Name is required');
    if (this.update_data.userinfo.gender == '') return this.$toast.error('Gender is required');
    if (this.update_data.userinfo.course_id == '') return this.$toast.error('Course is required');
    if (this.update_data.userinfo.section_id == '') return this.$toast.error('Section is required');
    if (this.update_data.userinfo.contact == '') return this.$toast.error('Contact is required');
    if (this.update_data.userinfo.type == '') return this.$toast.error('Account Type is required');
    if (this.update_data.userinfo.year_level == '') return this.$toast.error('Year Level is required');
    if (this.update_data.userinfo.organization_id == '') return this.$toast.error('Organization is required');
    if (this.update_data.userinfo.contact.match(contactval)) {
     this.isLoading = true;
     const { data, status } = await this.$store.dispatch('students/updateStudent', this.update_data);
     this.checkStatus(data, status, 'update', 'students/getStudents', 'students/allAdmins');
    } else {
     this.$toast.error('Contact must be a valid number and not contain any letters or special characters');
    }
   },
   async deleteStudent() {
    this.isLoading = true;
    const { data, status } = await this.$store.dispatch('students/deleteStudent', this.delete_data);
    this.checkStatus(data, status, '', 'students/getStudents', 'students/allAdmins');
   },
   closeModal() {
    this.$bvModal.hide(this.modalId);
   },
  },
 };
</script>
