<template>
	<div>
		<div class="navigation" v-if="user.userinfo">
			<div class="d-flex lh-0">
				<b-avatar variant="info" v-if="user.image" :src="`http://www.be.evsu-organization-system.com/uploads/` + user.image"></b-avatar>
				<b-avatar variant="info" v-else :text="user.userinfo.first_name[0] + user.userinfo.last_name[0]"></b-avatar>
				<div class="col">
					<p class="text-dark username" v-if="user">{{ user.userinfo.first_name }} {{ user.userinfo.last_name }}!</p>
					<p class="text-muted username" v-if="user">
						<small>{{ user.email }}</small>
					</p>
					<!-- <p class="text-muted username" v-if="user">
						<small>S.Y. {{ user.userinfo.academic_year }}</small>
					</p> -->
					<p class="text-muted username" v-if="user">
						<small>{{ user.userinfo.organization.organization }} - {{ user.userinfo.organization.orgtype.name }}</small>
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
	import { mapState, mapActions } from 'vuex';
	export default {
		async mounted() {
			await this.checkUser();
		},
		computed: {
			...mapState('auth', ['user']),
		},
		methods: {
			...mapActions('auth', ['checkUser']),
			toggleSideNav(){
					const sideNav = document.getElementById('sidenav')
					sideNav.classList.toggle('toggleNav')
			}
		},
	};
</script>
