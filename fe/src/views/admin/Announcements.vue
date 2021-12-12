<template>
 <div>
  <div class="container pt-5">
   <div class="row ">
    <h5 class="">Announcement Section</h5>
    <p class="text-muted">Organization announcements are listed below</p>
    <div class="col-12 col-sm-11 col-md-12 col-lg-11 col-xl-11 mt-4">
     <div class="card p-5">
      <div class="d-flex justify-content-end">
       <button class="btn btn-primary" v-on:click.prevent="$bvModal.show('addAnnouncementModal')"><i class="bi bi-node-plus me-2"></i>Create</button>
      </div>
      <div class="table-responsive mt-4">
       <table class="table table-striped table-hover">
        <caption>
         Showing
         {{
          allannouncements.from
         }}
         to
         {{
          allannouncements.to
         }}
         out of
         {{
          allannouncements.total
         }}
         data
        </caption>
        <thead>
         <tr>
          <th scope="col">ID</th>
          <th class="cursor-pointer" v-on:click.prevent="sort = sort == 'asc' ? 'desc' : 'asc'">
           What
           <i class="bi" :class="sort == 'asc' ? 'bi-arrow-up-short' : 'bi-arrow-down-short'"></i>
          </th>
          <th scope="col">Where</th>
          <th scope="col">When</th>
          <th scope="col">Who</th>
          <th scope="col">Organization</th>
          <th scope="col">Action</th>
         </tr>
        </thead>
        <tbody>
         <tr v-for="(announcement, i) in allannouncements.data" :key="i">
          <td scope="row">{{ i + allannouncements.from }}</td>
          <td>{{ announcement.what }}</td>
          <td>{{ announcement.where }}</td>
          <td>{{ announcement.when }}</td>
          <td>{{ announcement.who }}</td>
          <td>{{ announcement.organization.organization }}</td>
          <td>
           <div class="d-flex">
            <a
             v-if="announcement.organization_id == '1'"
             v-on:click.prevent="
              data = { ...announcement };
              $bvModal.show('updateAnnouncementModal');
             "
             href=""
             class="btn btn-primary btn-sm me-1 rounded-pill"
             ><i class="bi bi-pencil"></i
            ></a>
            <a
             v-on:click.prevent="
              delete_data.id = announcement.id;
              $bvModal.show('deleteAnnouncementModal');
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
       <div class="row mt-3" v-if="allannouncements.data">
        <pagination :showDisabled="true" :align="'right'" :data="allannouncements" @pagination-change-page="getAnnouncements">
         <span slot="prev-nav">&laquo;</span>
         <span slot="next-nav">&raquo;</span>
        </pagination>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>

  <b-modal id="addAnnouncementModal" centered title="Add Announcement">
   <div class="row pe-4 ps-4 pt-1 pb-2">
    <div class="col">
     <label class="mt-2" for="remarks">What</label>
     <textarea v-model="data.what" id="remarks" type="text" class="form-control" placeholder="" aria-label="What"></textarea>
     <label class="mt-2" for="remarks">Where</label>
     <textarea v-model="data.where" id="remarks" type="text" class="form-control" placeholder="" aria-label="Where"></textarea>
     <label class="mt-2" for="remarks">When</label>
     <textarea v-model="data.when" id="remarks" type="text" class="form-control" placeholder="" aria-label="When"></textarea>
     <label class="mt-2" for="remarks">Who</label>
     <textarea v-model="data.who" id="remarks" type="text" class="form-control" placeholder="" aria-label="Who"></textarea>
    </div>
   </div>
   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading"> Cancel </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="saveAnnouncement" :disabled="isLoading">
     Save
    </b-button>
   </template>
  </b-modal>

  <b-modal id="updateAnnouncementModal" centered title="Update Announcement">
   <div class="row pe-4 ps-4 pt-1 pb-2">
    <div class="col">
     <label class="mt-2" for="remarks">What</label>
     <textarea v-model="data.what" id="remarks" type="text" class="form-control" placeholder="" aria-label="What"></textarea>
     <label class="mt-2" for="remarks">Where</label>
     <textarea v-model="data.where" id="remarks" type="text" class="form-control" placeholder="" aria-label="Where"></textarea>
     <label class="mt-2" for="remarks">When</label>
     <textarea v-model="data.when" id="remarks" type="text" class="form-control" placeholder="" aria-label="When"></textarea>
     <label class="mt-2" for="remarks">Who</label>
     <textarea v-model="data.who" id="remarks" type="text" class="form-control" placeholder="" aria-label="Who"></textarea>
    </div>
   </div>
   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading"> Cancel </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="updateAnnouncement" :disabled="isLoading">
     Update
    </b-button>
   </template>
  </b-modal>

  <b-modal id="deleteAnnouncementModal" centered title="Confirm Delete">
   <p>Are you sure you want to delete?</p>
   <template #modal-footer="{cancel}">
    <b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading">
     Cancel
    </b-button>
    <b-button variant="success" size="sm" v-on:click.prevent="deleteAnnouncement" :disabled="isLoading">
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
     what: '',
     who: '',
     when: '',
     where: '',
    },
    delete_data: {
     id: '',
    },
    sort: 'asc',
   };
  },
  async mounted() {
   document.title = 'Organization Announcements';
   await this.$store.dispatch('auth/checkAdminUser');
   this.getAnnouncements();
   this.$root.$on('bv::modal::show', (modalId) => {
    this.modalId = modalId.componentId;
   });
   this.$root.$on('bv::modal::hide', (modalId) => {
    this.data.what = '';
    this.data.where = '';
    this.data.when = '';
    this.data.who = '';
   });
  },
  computed: {
   ...mapState('announcement', ['allannouncements']),
   ...mapState('students', ['announcements']),
   ...mapState('auth', ['user']),
  },
  methods: {
   async getAnnouncements(page = 1) {
    await this.$store.dispatch('announcement/allAnnouncements', {
     page: page,
     sort: this.sort,
    });
   },
   async saveAnnouncement() {
    if (this.data.what == '') return this.$toast.error('What input field is required');
    if (this.data.where == '') return this.$toast.error('Where input field is required');
    if (this.data.when == '') return this.$toast.error('When input field is required');
    if (this.data.who == '') return this.$toast.error('Who input field is required');

    this.isLoading = true;
    const { data, status } = await this.$store.dispatch('students/saveAnnouncement', this.data);
    this.checkStatus(data, status, '', 'announcement/allAnnouncements', '');
   },
   async updateAnnouncement() {
    if (this.data.what == '') return this.$toast.error('What input field is required');
    if (this.data.where == '') return this.$toast.error('Where input field is required');
    if (this.data.when == '') return this.$toast.error('When input field is required');
    if (this.data.who == '') return this.$toast.error('Who input field is required');

    this.isLoading = true;
    const { data, status } = await this.$store.dispatch('students/updateAnnouncement', this.data);
    this.checkStatus(data, status, 'update', 'announcement/allAnnouncements', '');
   },
   async deleteAnnouncement() {
    this.isLoading = true;
    const { data, status } = await this.$store.dispatch('announcement/deleteAnnouncement', this.delete_data);
    this.checkStatus(data, status, '', 'announcement/allAnnouncements', '');
   },
   closeModal() {
    this.$bvModal.hide(this.modalId);
   },
  },
  watch: {
   sort() {
    this.getAnnouncements();
   },
  },
 };
</script>
