<template>
  <div>
    <div class="container pt-5">
      <div class="row ">
        <h5 class="">College Section</h5>
        <p class="text-muted">Manage the university colleges below</p>
        <div class="col-12 col-sm-11 col-md-12 col-lg-11 col-xl-11 mt-4">
          <div class="card p-5">
            <div class="d-flex justify-content-end">
              <button
                class="btn btn-primary"
                v-on:click.prevent="$bvModal.show('addCollegeModal')"
              >
                <i class="bi bi-node-plus me-2"></i>College
              </button>
            </div>
            <b-skeleton-table
              :rows="6"
              :columns="6"
              :table-props="{ bordered: true, striped: true }"
              class="mt-4"
              v-if="initialLoading"
            ></b-skeleton-table>
            <div class="table-responsive mt-4" v-else>
              <table class="table table-striped table-hover">
                <caption>
                  Showing
                  {{
                    colleges.from
                  }}
                  to
                  {{
                    colleges.to
                  }}
                  out of
                  {{
                    colleges.total
                  }}
                  data
                </caption>
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th
                      class="cursor-pointer"
                      v-on:click.prevent="sort = sort == 'asc' ? 'desc' : 'asc'"
                    >
                      College
                      <i
                        class="bi"
                        :class="
                          sort == 'asc'
                            ? 'bi-arrow-up-short'
                            : 'bi-arrow-down-short'
                        "
                      ></i>
                    </th>
                    <th scope="col">Abbreviation</th>
                    <th scope="col">Mission</th>
                    <th scope="col">Vision</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(college, i) in colleges.data" :key="i">
                    <td scope="row">{{ i + colleges.from }}</td>
                    <td>{{ college.college }}</td>
                    <td>{{ college.abbreviation }}</td>
                    <td>{{ college.mission }}</td>
                    <td>{{ college.vision }}</td>
                    <td>
                      <div class="d-flex">
                        <a
                          v-on:click.prevent="
                            data = { ...college };
                            $bvModal.show('updateCollegeModal');
                          "
                          href=""
                          class="btn btn-primary btn-sm me-1 rounded-pill"
                          ><i class="bi bi-pencil"></i
                        ></a>
                        <a
                          v-on:click.prevent="
                            delete_data.id = college.id;
                            $bvModal.show('deleteCollegeModal');
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
              <div class="row mt-3" v-if="colleges.data">
                <pagination
                  :showDisabled="true"
                  :align="'right'"
                  :data="colleges"
                  @pagination-change-page="getColleges"
                >
                  <span slot="prev-nav">&laquo;</span>
                  <span slot="next-nav">&raquo;</span>
                </pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <b-modal id="addCollegeModal" centered title="Add College">
      <div class="row pe-4 ps-4 pt-1 pb-2">
        <div class="col">
          <label class="mt-2" for="item">College</label>
          <input
            v-model="data.college"
            id="item"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="First Name"
          />
          <label class="mt-2" for="remarks"
            >Abbreviation <small>(Optional)</small></label
          >
          <input
            v-model="data.abbreviation"
            id="remarks"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Middle Name"
          />
          <label class="mt-2" for="remarks">Mission</label>
          <textarea
            v-model="data.mission"
            id="remarks"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Mission"
          ></textarea>
          <label class="mt-2" for="remarks">Vision</label>
          <textarea
            v-model="data.vision"
            id="remarks"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Vision"
          ></textarea>
        </div>
      </div>
      <template #modal-footer="{cancel}">
        <b-button
          variant="primary"
          size="sm"
          @click="cancel()"
          :disabled="isLoading"
        >
          Cancel
        </b-button>
        <b-button
          variant="success"
          size="sm"
          v-on:click.prevent="saveCollege"
          :disabled="isLoading"
        >
          Save
        </b-button>
      </template>
    </b-modal>

    <b-modal id="updateCollegeModal" centered title="Update College">
      <div class="row pe-4 ps-4 pt-1 pb-2">
        <div class="col">
          <label class="mt-2" for="item">College</label>
          <input
            v-model="data.college"
            id="item"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="College"
          />
          <label class="mt-2" for="remarks"
            >Abbreviation <small>(Optional)</small></label
          >
          <input
            v-model="data.abbreviation"
            id="remarks"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Abbreviation"
          />
          <label class="mt-2" for="remarks">Mission</label>
          <textarea
            v-model="data.mission"
            id="remarks"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Mission"
          ></textarea>
          <label class="mt-2" for="remarks">Vision</label>
          <textarea
            v-model="data.vision"
            id="remarks"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Vision"
          ></textarea>
        </div>
      </div>
      <template #modal-footer="{cancel}">
        <b-button
          variant="primary"
          size="sm"
          @click="cancel()"
          :disabled="isLoading"
        >
          Cancel
        </b-button>
        <b-button
          variant="success"
          size="sm"
          v-on:click.prevent="updateCollege"
          :disabled="isLoading"
        >
          Update
        </b-button>
      </template>
    </b-modal>

    <b-modal id="deleteCollegeModal" centered title="Confirm Delete">
      <p>Are you sure you want to delete?</p>
      <template #modal-footer="{cancel}">
        <b-button
          variant="primary"
          size="sm"
          @click="cancel()"
          :disabled="isLoading"
        >
          Cancel
        </b-button>
        <b-button
          variant="success"
          size="sm"
          v-on:click.prevent="deleteCollege"
          :disabled="isLoading"
        >
          Delete
        </b-button>
      </template>
    </b-modal>
  </div>
</template>
<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      data: {
        mission: "",
        vision: "",
        college: "",
        abbreviation: "",
      },
      delete_data: {
        id: "",
      },
      sort: "asc",
    };
  },
  async mounted() {
    this.initialLoading = true;
    await this.$store.dispatch("auth/checkAdminUser");
    this.getColleges();
    this.$root.$on("bv::modal::show", (modalId) => {
      this.modalId = modalId.componentId;
    });
    this.$root.$on("bv::modal::hide", (modalId) => {
      this.data.mission = "";
      this.data.vision = "";
      this.data.college = "";
      this.data.abbreviation = "";
    });
    this.initialLoading = false;
  },
  computed: {
    ...mapState("college", ["colleges"]),
  },
  methods: {
    async getColleges(page = 1) {
      await this.$store.dispatch("college/getColleges", {
        page: page,
        sort: this.sort,
      });
    },
    async saveCollege() {
      if (this.data.college.trim() == "")
        return this.$toast.error("College is required");
      if (this.data.mission.trim() == "")
        return this.$toast.error("Mission is required");
      if (this.data.vision.trim() == "")
        return this.$toast.error("Vision is required");

      this.isLoading = true;
      const { data, status } = await this.$store.dispatch(
        "college/saveCollege",
        this.data
      );
      this.checkStatus(data, status, "", "college/getColleges");
    },
    async updateCollege() {
      if (this.data.college.trim() == "")
        return this.$toast.error("College is required");
      if (this.data.mission.trim() == "")
        return this.$toast.error("Mission is required");
      if (this.data.vision.trim() == "")
        return this.$toast.error("Vision is required");

      this.isLoading = true;
      const { data, status } = await this.$store.dispatch(
        "college/updateCollege",
        this.data
      );
      this.checkStatus(data, status, "update");
    },
    async deleteCollege() {
      this.isLoading = true;
      const { data, status } = await this.$store.dispatch(
        "college/deleteCollege",
        this.delete_data
      );
      this.checkStatus(data, status, "", "college/getColleges");
    },
    closeModal() {
      this.$bvModal.hide(this.modalId);
    },
  },
  watch: {
    sort() {
      this.getColleges();
    },
  },
};
</script>
