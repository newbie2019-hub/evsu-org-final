<template>
  <div>
    <div class="container pt-5">
      <div class="row ">
        <h5 class="">Course Management</h5>
        <p class="text-muted">Manage the courses offered by the university</p>
        <div class="col-12 col-sm-11 col-md-12 col-lg-11 col-xl-11 mt-4">
          <div class="card p-5">
            <div class="d-flex justify-content-end">
              <button
                v-on:click.prevent="$bvModal.show('addCourseModal')"
                class="btn btn-primary"
              >
                <i class="bi bi-node-plus me-2"></i>Course
              </button>
            </div>
            <b-skeleton-table
              :rows="5"
              :columns="5"
              :table-props="{ bordered: true, striped: true }"
              class="mt-4"
              v-if="initialLoading"
            ></b-skeleton-table>
            <div class="table-responsive mt-4" v-else>
              <table class="table table-striped table-hover">
                <caption>
                  Showing
                  {{
                    courses.from
                  }}
                  to
                  {{
                    courses.to
                  }}
                  out of
                  {{
                    courses.total
                  }}
                  data
                </caption>
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">College</th>
                    <th
                      class="cursor-pointer"
                      v-on:click.prevent="sort = sort == 'asc' ? 'desc' : 'asc'"
                    >
                      Course
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
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(course, i) in courses.data" :key="i">
                    <td scope="row">{{ i + courses.from }}</td>
                    <td>{{ course.college.college }}</td>
                    <td>{{ course.course }}</td>
                    <td>{{ course.abbreviation }}</td>
                    <td>
                      <div class="d-flex">
                        <a
                          v-on:click.prevent="
                            data = JSON.parse(JSON.stringify(course));
                            $bvModal.show('updateCourseModal');
                          "
                          href=""
                          class="btn btn-primary btn-sm me-1 rounded-pill"
                          ><i class="bi bi-pencil"></i
                        ></a>
                        <a
                          v-on:click.prevent="
                            delete_data.id = course.id;
                            $bvModal.show('deleteCourseModal');
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
              <div class="row mt-3" v-if="courses.data">
                <pagination
                  :showDisabled="true"
                  :align="'right'"
                  :data="courses"
                  @pagination-change-page="getCourses"
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

    <b-modal id="addCourseModal" centered title="Add Course">
      <div class="row pe-4 ps-4 pt-1 pb-2">
        <div class="col">
          <label class="mt-2" for="item">College</label>
          <select v-model="data.college_id" class="form-select">
            <option :value="c.id" v-for="(c, i) in allcolleges" :key="i">{{
              c.college
            }}</option>
          </select>
          <label class="mt-2" for="remarks">Course</label>
          <input
            v-model="data.course"
            id="remarks"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Course"
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
          v-on:click.prevent="saveCourse"
          :disabled="isLoading"
        >
          Save
        </b-button>
      </template>
    </b-modal>

    <b-modal id="updateCourseModal" centered title="Update Course">
      <div class="row pe-4 ps-4 pt-1 pb-2">
        <div class="col">
          <label class="mt-2" for="item">College</label>
          <input
            v-model="data.college.college"
            id="remarks"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Course"
            disabled
          />
          <label class="mt-2" for="remarks">Course</label>
          <input
            v-model="data.course"
            id="remarks"
            type="text"
            class="form-control"
            placeholder=""
            aria-label="Course"
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
          v-on:click.prevent="updateCourse"
          :disabled="isLoading"
        >
          Update
        </b-button>
      </template>
    </b-modal>

    <b-modal id="deleteCourseModal" centered title="Confirm Delete">
      <p>Are you sure you want to delete this course?</p>
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
          v-on:click.prevent="deleteCourse"
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
        college_id: "",
        course: "",
        abbreviation: "",
        college: {},
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
    await this.$store.dispatch("college/allColleges");
    this.getCourses();
    this.$root.$on("bv::modal::show", (modalId) => {
      this.modalId = modalId.componentId;
    });
    this.$root.$on("bv::modal::hide", (modalId) => {
      this.data.college_id = "";
      this.data.course = "";
      this.data.abbreviation = "";
    });
    this.initialLoading = false;
  },
  computed: {
    ...mapState("college", ["allcolleges"]),
    ...mapState("courses", ["courses"]),
  },
  methods: {
    async getCourses(page = 1) {
      await this.$store.dispatch("courses/getCourses", {
        page: page,
        sort: this.sort,
      });
    },
    async saveCourse() {
      if (this.data.course.trim() == "")
        return this.$toast.error("Course name is required");
      if (this.data.college_id == "")
        return this.$toast.error("College is required");

      this.isLoading = true;
      const { data, status } = await this.$store.dispatch(
        "courses/saveCourse",
        this.data
      );
      this.checkStatus(data, status, "", "courses/getCourses");
    },
    async updateCourse() {
      if (this.data.course.trim() == "")
        return this.$toast.error("Course name is required");
      if (this.data.college_id == "")
        return this.$toast.error("College is required");

      this.isLoading = true;
      const { data, status } = await this.$store.dispatch(
        "courses/updateCourse",
        this.data
      );
      this.checkStatus(data, status, "update");
    },
    async deleteCourse() {
      this.isLoading = true;
      const { data, status } = await this.$store.dispatch(
        "courses/deleteCourse",
        this.delete_data
      );
      this.checkStatus(data, status, "", "courses/getCourses");
    },
    closeModal() {
      this.$bvModal.hide(this.modalId);
    },
  },
  watch: {
    sort() {
      this.getCourses();
    },
  },
};
</script>
