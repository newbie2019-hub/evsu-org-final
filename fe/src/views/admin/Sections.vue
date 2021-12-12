<template>
  <div>
    <div class="container pt-5">
      <div class="row ">
        <h5 class="">Section Management</h5>
        <p class="text-muted">Manage the sections below</p>
        <div class="col-12 col-sm-11 col-md-12 col-lg-11 col-xl-11 mt-4">
          <div class="card p-5">
            <div class="d-flex justify-content-end">
              <button
                v-on:click.prevent="$bvModal.show('addSectionModal')"
                class="btn btn-primary"
              >
                <i class="bi bi-node-plus me-2"></i>Section
              </button>
            </div>
            <b-skeleton-table
              :rows="5"
              :columns="4"
              :table-props="{ bordered: true, striped: true }"
              class="mt-4"
              v-if="initialLoading"
            ></b-skeleton-table>
            <div class="table-responsive mt-4" v-else>
              <table class="table table-striped table-hover">
                <caption>
                  Showing
                  {{
                    sections.from
                  }}
                  to
                  {{
                    sections.to
                  }}
                  out of
                  {{
                    sections.total
                  }}
                  data
                </caption>
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Year Level</th>
                    <th
                      class="cursor-pointer"
                      v-on:click.prevent="sort = sort == 'asc' ? 'desc' : 'asc'"
                    >
                      Section
                      <i
                        class="bi"
                        :class="
                          sort == 'asc'
                            ? 'bi-arrow-up-short'
                            : 'bi-arrow-down-short'
                        "
                      ></i>
                    </th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(sec, i) in sections.data" :key="i">
                    <td scope="row">{{ i + 1 }}</td>
                    <td>{{ sec.year_level }}</td>
                    <td>{{ sec.section }}</td>
                    <td>
                      <div class="d-flex">
                        <a
                          v-on:click.prevent="
                            data = JSON.parse(JSON.stringify(sec));
                            $bvModal.show('updateSectionModal');
                          "
                          href=""
                          class="btn btn-primary btn-sm me-1 rounded-pill"
                          ><i class="bi bi-pencil"></i
                        ></a>
                        <a
                          v-on:click.prevent="
                            delete_data.id = sec.id;
                            $bvModal.show('deleteSectionModal');
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
              <div class="row mt-3" v-if="sections.data">
                <pagination
                  :showDisabled="true"
                  :align="'right'"
                  :data="sections"
                  @pagination-change-page="getSections"
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

    <b-modal id="addSectionModal" centered title="Add Section">
      <div class="row pe-4 ps-4 pt-1 pb-2">
        <div class="col">
          <label class="mt-2" for="yearlevel">Year Level</label>
          <select v-model="data.year_level" class="form-select">
            <option value="I">I</option>
            <option value="II">II</option>
            <option value="III">III</option>
            <option value="IV">IV</option>
          </select>
          <label class="mt-2" for="section">Section</label>
          <input
            v-model="data.section"
            id="section"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Section"
          />
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
          v-on:click.prevent="saveSection"
          :disabled="isLoading"
        >
          Save
        </b-button>
      </template>
    </b-modal>

    <b-modal id="updateSectionModal" centered title="Update Section">
      <div class="row pe-4 ps-4 pt-1 pb-2">
        <div class="col">
          <label class="mt-2" for="yearlevel">Year Level</label>
          <select v-model="data.year_level" class="form-select">
            <option value="I">I</option>
            <option value="II">II</option>
            <option value="III">III</option>
            <option value="IV">IV</option>
          </select>
          <label class="mt-2" for="section">Section</label>
          <input
            v-model="data.section"
            id="section"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Section"
          />
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
          v-on:click.prevent="updateSection"
          :disabled="isLoading"
        >
          Update
        </b-button>
      </template>
    </b-modal>

    <b-modal id="deleteSectionModal" centered title="Confirm Delete">
      <p>Are you sure you want to delete this section?</p>
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
          v-on:click.prevent="deleteSection"
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
        section: "",
        year_level: "",
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
    this.getSections();
    this.$root.$on("bv::modal::show", (modalId) => {
      this.modalId = modalId.componentId;
    });
    this.$root.$on("bv::modal::hide", (modalId) => {
      this.data.section = "";
      this.data.year_level = "";
    });
    this.initialLoading = false;
  },
  computed: {
    ...mapState("sections", ["sections"]),
  },
  methods: {
    async getSections(page = 1) {
      await this.$store.dispatch("sections/getSections", {
        page: page,
        sort: this.sort,
      });
    },
    async saveSection() {
      if (this.data.section.trim() == "")
        return this.$toast.error("Section is required");
      if (this.data.year_level == "")
        return this.$toast.error("Year Level is required");

      this.isLoading = true;
      const { data, status } = await this.$store.dispatch(
        "sections/saveSection",
        this.data
      );
      this.checkStatus(data, status, "", "sections/getSections");
    },
    async updateSection() {
      if (this.data.section.trim() == "")
        return this.$toast.error("Section is required");
      if (this.data.year_level == "")
        return this.$toast.error("Year Level is required");

      this.isLoading = true;
      const { data, status } = await this.$store.dispatch(
        "sections/updateSection",
        this.data
      );
      this.checkStatus(data, status, "update");
    },
    async deleteSection() {
      this.isLoading = true;
      const { data, status } = await this.$store.dispatch(
        "sections/deleteSection",
        this.delete_data
      );
      this.checkStatus(data, status, "", "sections/getSections");
    },
    closeModal() {
      this.$bvModal.hide(this.modalId);
    },
  },
  watch: {
    sort() {
      this.getSections();
    },
  },
};
</script>
