<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Projects</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal()">
                Add new
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
              <thead class>
                <tr>
                  <th>id</th>
                  <!-- <th>Icon</th> -->
                  <th>Name</th>
                  <th>Priority</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Number Of Sprints</th>
                  <th>Completation Level</th>
                  <th>Status</th>
                  <th>Description</th>
                  <th>Assigned to</th>
                  <th>Belong to</th>
                  <th>Under The following Contracts</th>
                  <th>Created at</th>
                  <th>Updated at</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="project in projects.data" :key="project.id">
                  <td>{{ project.id }}</td>
                  <td>{{ project.project_name }}</td>
                  <td>{{ project.project_priority }}</td>
                  <td>{{ project.project_start_date }}</td>
                  <td>{{ project.project_final_deadline }}</td>
                  <td>{{ project.project_sprint_number }}</td>
                  <td>{{ project.project_cmp_level }}</td>
                  <td>{{ project.project_status }}</td>
                  <td>{{ project.project_description }}</td>
                  <td>
                    <ul>
                      <li v-for="user in project.users" :key="user.id">{{ user.user_name }}</li>
                    </ul>
                  </td>
                  <td>
                    <ul>
                      <li v-for="agent in project.agents" :key="agent.id">{{ agent.agent_name }}</li>
                    </ul>
                  </td>
                  <td>
                    <ul>
                      <li>{{ project.contracts.contract_name }}</li>
                    </ul>
                  </td>
                  <td>{{ project.created_at }}</td>
                  <td>{{ project.updated_at }}</td>
                  <td>
                    <a href="#" @click="editModal(project)">
                      <i class="fa fa-edit green pr-1"></i>
                    </a>
                    <a href="#" @click="deleteProject(project.id)">
                      <i class="fa red fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body meawww-->
          <div class="card-footer">
            <pagination :data="projects" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div v-if="!$gate.isAdmin()">
      <not-found></not-found>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New Project</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update Project Info</h5>
            <b-alert
              :show="dismissCountDown"
              dismissible
              variant="danger"
              @dismissed="dismissCountDown=0"
              @dismiss-count-down="countDownChanged"
            >
              {{ errorMsg }}
              <b-progress
                variant="danger"
                :max="dismissSecs"
                :value="dismissCountDown"
                height="4px"
              ></b-progress>
            </b-alert>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateProject() : createProject()">
            <div class="modal-body">
              <div class="form-group">
                <label for="projectName">Project's Name</label>
                <input
                  v-model="form.project_name"
                  id="projectName"
                  type="text"
                  class="form-control"
                />
              </div>
              <!-- <div class="form-group">
                <label for="projectIcon">Project's Icon</label>
                <input
                  v-model="form.project_icon"
                  id="projectIcon"
                  type="text"
                  class="form-control"
                />
              </div>-->
              <div class="form-group">
                <label for="projectPriority">Project's Priority</label>
                <input
                  v-model="form.project_priority"
                  id="projectPriority"
                  type="text"
                  class="form-control"
                />
              </div>
              <div class="container">
                <div class="row">
                  <div class="col-sm form-group">
                    <label for="project_start_date">Project Start Date</label>
                    <input
                      v-model="form.project_start_date"
                      class="form-control"
                      type="date"
                      id="start"
                      name="project_start_date"
                    />
                  </div>
                  <div class="col-sm form-group">
                    <label for="project_final_deadline">Project Final Date</label>
                    <input
                      v-model="form.project_final_deadline"
                      type="date"
                      id="project_final_deadline"
                      class="form-control"
                    />
                  </div>

                  <!-- <div class="col-sm">
            One of three columns
            </div>
            <div class="col-sm">
            One of three columns
                  </div>-->
                </div>
              </div>
              <div class="form-group">
                <label for="project_cmp_level">Project's Completation Level</label>
                <input
                  v-model="form.project_cmp_level"
                  id="project_cmp_level"
                  type="number"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="project_status">Project Status</label>
                <!-- <input v-model="project_status" id="project_status" class="form-control"> -->
                <select
                  v-model="form.project_status"
                  name="carlist"
                  class="form-control"
                  form="carform"
                >
                  <option
                    v-for="statusaya in statusList"
                    :key="statusaya.id"
                    class="form-group"
                  >{{ statusaya.status_name }}</option>
                </select>
              </div>
              <div class="form-group">
                <label for="project_contract">Project Contract</label>
                <!-- <input v-model="project_contract" id="project_contract" class="form-control"> -->
                <select
                  v-model="form.project_contract"
                  name="carlist"
                  class="form-control"
                  form="carform"
                >
                  <option
                    v-for="contract in contractslist"
                    :key="contract.id"
                    :value="contract.id"
                    class="form-group"
                  >{{ contract.contract_name }}</option>
                </select>
              </div>
              <div class="form-group">
                <label for="project_description">Project's Description</label>
                <textarea
                  v-model="form.project_description"
                  id="project_description"
                  type="text"
                  class="form-control"
                ></textarea>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Update Project</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Create Project</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      editmode: true,
      errorMsg: "",
      dismissSecs: 10,
      dismissCountDown: 0,
      statusList: [],
      projects: {},
      agentslist: [],
      contractslist: [],
      tiersList: [],
      classList: [],
      sprintNumber: "",
      form: new Form({
        id: "",
        project_name: "",
        project_icon: "",
        project_priority: "",
        project_final_deadline: "",
        project_start_date: "",
        project_current_milestone: "",
        project_sprint_number: "",
        project_cmp_level: "",
        project_status: "",
        project_description: "",
        project_contract: ""
      })
    };
  },
  mounted() {
    axios.get("api/getTiers").then(({ data }) => (this.tiersList = data));
    axios.get("api/getStatus").then(({ data }) => (this.statusList = data));
    axios.get("api/getClass").then(({ data }) => (this.classList = data));
    axios.get("api/getAgents").then(({ data }) => (this.agents = data));
  },
  methods: {
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getResults(page = 1) {
      axios.get("api/project?page=" + page).then(response => {
        this.projects = response.data;
      });
    },
    updateProject(id) {
      if (this.form.project_start_date > this.form.project_final_deadline) {
        this.showAlert();
        this.errorMsg = "Start date cannot be less than end date";
        this.showDismissibleAlert ? true : false;
        return;
      }
      const timeDiff =
        new Date(this.form.project_final_deadline) -
        new Date(this.form.project_start_date);
      const days = timeDiff / (1000 * 60 * 60 * 24);
      alert(days);
      this.sprintNumber = days / 14;
      alert(this.sprintNumber);

    this.form.project_sprint_number = Math.round(this.sprintNumber*2)/2;

      this.$Progress.start();
      this.form
        .put("api/project/" + this.form.id)
        .then(() => {
          Fire.$emit("AfterProjectCreated");
          $("#addNew").modal("hide");
          swal.fire("Updated!", "Project has been updated.", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          swal.fire("Failed", "Something wrong", "warning");

          this.$Progress.fail();
        });
    },
    editModal(project) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(project);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteProject(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            this.form
              .delete("api/project/" + id)
              .then(() => {
                Fire.$emit("AfterProjectCreated");

                swal.fire("Deleted!", "Your file has been deleted.", "success");
              })
              .catch(() => {
                swal.fire("Failed", "Something wrong", "warning");
              });
          }
        });
    },
    createProject() {
      if (this.form.project_start_date > this.form.project_final_deadline) {
        this.showAlert();
        this.errorMsg = "Start date cannot be less than end date";
        this.showDismissibleAlert ? true : false;
        return;
      }

      // Submit the form via a POST request
      this.$Progress.start();
      this.form
        .post("api/project")
        .then(() => {
          Fire.$emit("AfterProjectCreated");
          $("#addNew").modal("hide");
          toast({
            type: "success",
            title: "Project Created successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    loadProjects() {
      if (this.$gate.isAdmin() || this.$gate.isAgent()) {
        axios.get("api/project").then(({ data }) => (this.projects = data));
      }
    },
    loadContracts() {
      if (this.$gate.isAdmin() || this.$gate.isAgent()) {
        axios
          .get("api/getContracts")
          .then(({ data }) => (this.contractslist = data));
      }
    },
    listenForChanges() {
      Echo.channel("projects").listen("ProjectPublished", Project => {
        this.loadProjects();
        this.showDismissibleAlert ? "visible" : "hidden";
      });
      Echo.channel("projects").listen("ProjectRemoved", Project => {
        this.loadProjects();

        this.showDismissibleAlert ? "visible" : "hidden";
      });
      Echo.channel("projects").listen("ProjectUpdated", Project => {
        this.loadProjects();

        this.showDismissibleAlert ? "visible" : "hidden";
      });
    }
  },

  created() {
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/FindProject?q=" + query)
        .then(() => {
          this.projects = data.tata;
        })
        .catch(() => {
          swal.fire("Failed", "Something wrong", "warning");
        });
    });
    this.loadProjects();
    this.loadContracts();
    Fire.$on("AfterProjectCreated", () => {
      this.loadProjects();
    });
    // setInterval(()=>this.loadProjects(), 3000);
  }
};
</script>
