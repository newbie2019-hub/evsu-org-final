<template>
  <div>
    <Sidenav />
    <Navbar />
    <div class="content-container">
      <router-view name="colleges" />
      <router-view name="courses" />
      <router-view name="organizations" />
      <router-view name="students" />
      <router-view name="sections" />
      <router-view name="announcements" />
    </div>
  </div>
</template>
<script>
import Sidenav from "./components/Sidebar.vue";
import Navbar from "./components/Navbar.vue";
export default {
  async mounted() {
    document.title = "Admin Dashboard";
    await this.$store.dispatch("auth/checkAdminUser");
  },
  components: { Sidenav, Navbar },
};
</script>
