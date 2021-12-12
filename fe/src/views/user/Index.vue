<template>
 <div>
   <Sidenav />
   <Navbar />
   <div class="content-container">
    <router-view name="members"/>
    <router-view name="payment"/>
    <router-view name="userannouncement"/>
    <router-view name="chat"/>
   </div>
 </div>
</template>
<script>
import Sidenav from './components/Sidebar.vue'
import Navbar from './components/Navbar.vue'
export default {
   components: {Sidenav, Navbar}
}
</script>