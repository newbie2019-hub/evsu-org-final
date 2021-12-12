<template>
  <div>
    <div class="navigation" v-if="user.admininfo">
      <div class="d-flex">
        <b-avatar variant="info" v-if="user.admininfo.image" :src="`http://www.be.evsu-organization-system.com/uploads/` + user.admininfo.image"></b-avatar>
        <b-avatar variant="info" v-else :text="user.admininfo.first_name[0] + user.admininfo.last_name[0]"></b-avatar>
        <div class="col">
          <p class="text-dark username lh-sm" v-if="user">
            {{ user.admininfo.first_name }}
            {{ user.admininfo.last_name }}!
          </p>
          <p class="text-muted username lh-sm" v-if="user">
            <small>{{ user.email }}</small>
          </p>
        </div>
      </div>
      <div>
        <button class="btn btn-toggle" id="btn-toggle" @click.prevent="toggleSideNav">
          <i class="bi bi-list bi-2x"></i>
        </button>
      </div>
      
    </div>
  </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  async mounted() {
    await this.checkAdminUser();
  },
  computed: {
    ...mapState("auth", ["user"]),
  },
  methods: {
    ...mapActions("auth", ["checkAdminUser"]),
    toggleSideNav(){
      const sideNav = document.getElementById('sidenav')
      sideNav.classList.toggle('toggleNav')
    }
  },
};
</script>
