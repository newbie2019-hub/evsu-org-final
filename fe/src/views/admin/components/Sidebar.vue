<template>
	<div id="sidenav" class="sidenav">
		<p class="text-center mt-5 mb-4 text-white fw-bolder">ADMIN</p>
		<!-- <router-link to="/dashboard/home"><i class="bi bi-house"></i> Dashboard</router-link> -->
		<router-link to="/dashboard/colleges"><i class="bi bi-plus-circle "></i><span>Colleges</span></router-link>
		<router-link to="/dashboard/courses"><i class="bi bi-diagram-2"></i><span>Courses</span></router-link>
		<router-link to="/dashboard/organizations"><i class="bi bi-people"></i> <span>Organization</span></router-link>
		<!-- <router-link to="/dashboard/sections"><i class="bi bi-cursor"></i> Sections</router-link> -->
		<router-link to="/dashboard/students"><i class="bi bi-person-circle"></i> <span>Students</span></router-link>
		<router-link to="/dashboard/announcements"><i class="bi bi-megaphone"></i> <span>Announcements</span></router-link>
		<a
			href=""
			v-on:click.prevent="
				setValues();
				$bvModal.show('settingsModal');
			"
			><i class="bi bi-tools"></i> <span>Settings</span></a
		>
		<a href="" v-on:click.prevent="$bvModal.show('logoutModal')"><i class="bi bi-x-circle"></i> <span>Log-out</span></a>

		<b-modal id="logoutModal" centered title="Logout">
			<p class="my-4">Are you sure you want to log-out?</p>
			<template #modal-footer="{cancel}">
				<b-button variant="primary" size="sm" @click="cancel()"> Cancel </b-button>
				<b-button size="sm" variant="danger" v-on:click.prevent="logout">
					Logout
				</b-button>
			</template>
		</b-modal>

		<b-modal id="settingsModal" scrollable centered title="Account Settings">
			<div class="row pe-4 ps-4 pt-2 pb-2">
				<div class="col">
					<label for="item">Upload Image </label>
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
					<small class="mb-2 text-muted">This will replace your current image</small><br />

					<label for="firstname">First Name</label>
					<input v-model="data.first_name" id="firstname" type="text" class="form-control" placeholder="" aria-label="First Name" />

					<label for="middlename">Middle Name</label>
					<input v-model="data.middle_name" id="middlename" type="text" class="form-control" placeholder="" aria-label="Middle Name" />

					<label for="lastname">Last Name</label>
					<input v-model="data.last_name" id="lastname" type="text" class="form-control" placeholder="" aria-label="Last Name" />

					<label for="contactnumber">Contact Number</label>
					<input v-model="data.contact_number" id="contactnumber" type="text" class="form-control" placeholder="" aria-label="Last Name" />

					<label for="gender">Select Gender</label>
					<select id="gender" v-model="data.gender" class="form-select">
						<option value="" disabled selected>Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>

					<label for="email">Email</label>
					<input v-model="data.email" id="email" type="text" class="form-control" placeholder="" aria-label="Email" />
				</div>
			</div>
			<template #modal-footer="{cancel}">
				<b-button variant="primary" size="sm" @click="cancel()" :disabled="isLoading"> Close </b-button>
				<b-button variant="success" size="sm" v-on:click.prevent="$bvModal.show('saveChangesModal')" :disabled="isLoading">
					Update
				</b-button>
			</template>
		</b-modal>

		<b-modal id="saveChangesModal" centered title="Save Changes">
			<div class="p-3">
				<p class="">Please enter your password</p>
				<input v-model="data.confirm_password" type="password" class="form-control" />
			</div>
			<template #modal-footer="{cancel}">
				<b-button variant="primary" @click="cancel()" :disabled="isLoading"> Cancel </b-button>
				<b-button variant="success" v-on:click.prevent="updateAccount" :disabled="isLoading">
					{{ isLoading ? 'Saving Changes ...' : 'Save Changes' }}
				</b-button>
			</template>
		</b-modal>
		<div id="closenav" class="closenav" @click.prevent="toggleSideNav">
				<p>X</p>
		</div>
	</div>
</template>
<script>
	import moment from 'moment';
	import { mapActions, mapState } from 'vuex';
	export default {
		data() {
			return {
				data: {
					id: '',
					first_name: '',
					middle_name: '',
					last_name: '',
					gender: '',
					email: '',
					password: '',
					confirm_password: '',
				},
				isLoading: false,
				fileRecords: [],
				fileRecordsForUpload: [],
			};
		},
		filters: {
			moment: function(date) {
				return moment(date).format('MMMM DD, YYYY');
			},
		},
		mounted() {
			this.setValues();
			this.$root.$on('bv::modal::show', (modalId) => {
				this.modalId = modalId.componentId;
				if (this.modalId == 'saveChangesModal') {
					this.$bvModal.hide('settingsModal');
				}
			});
			console.clear();
		},
		methods: {
			...mapActions('auth', ['logoutUser']),
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
			async logout() {
				const res = await this.logoutUser();
				if (res.status == 200) {
					this.$router.push('/');
				}
			},
			setValues() {
				this.data.id = this.user.id;
				this.data.first_name = this.user.admininfo.first_name;
				this.data.middle_name = this.user.admininfo.middle_name;
				this.data.last_name = this.user.admininfo.last_name;
				this.data.gender = this.user.admininfo.gender;
				this.data.contact_number = this.user.admininfo.contact_number;
				this.data.email = this.user.email;
			},
			async updateAccount() {
				this.isLoading = true;
				if (this.fileRecordsForUpload.length > 0) {
					const img = await this.$refs.vueFileAgent.upload('http://www.be.evsu-organization-system.com/api/uploadImage', { 'X-Requested-With': 'XMLHttpRequest' }, this.fileRecordsForUpload);
					this.data.image = img[0].data;
				}

				const res = await this.$store.dispatch('auth/updateAdminAccount', this.data);
				if (res.status == 200) {
					this.$toast.success(res.data.msg);
					await this.$store.dispatch('auth/checkAdminUser');
					this.$bvModal.hide('saveChangesModal');
					this.data.confirm_password = '';
				} else {
					this.data.confirm_password = '';
					this.$toast.error(res.data.msg);
				}
				this.isLoading = false;
			},
			toggleSideNav(){
					const sideNav = document.getElementById('sidenav')
					sideNav.classList.toggle('toggleNav')
			}
		},
		computed: {
			...mapState('auth', ['user']),
			getRoute: function() {
				return this.$route.path;
			},
		},
	};
</script>
