<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Agents</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal()">
                Add new
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive" style="overflow-x: auto">
            <table class="table table-hover">
              <thead class>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Website</th>
                  <th>Main Contact Name</th>
                  <th>Moto</th>
                  <th>Business</th>
                  <th>Tier</th>
                  <th>Class</th>
                  <th>Status</th>
                  <th>Contact Info</th>
                  <th>Image</th>
                  <th>Projects</th>
                  <th>Created at</th>
                  <th>Updated at</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="agent in agents.data" :key="agent.id">
                  <td>{{ agent.id }}</td>
                  <td>{{ agent.agent_name }}</td>
                  <td>{{ agent.agent_website }}</td>
                  <td>{{ agent.agent_main_contact_name }}</td>
                  <td>{{ agent.agent_moto }}</td>
                  <td>{{ agent.agent_business }}</td>
                  <td>{{ agent.tier }}</td>
                  <td>{{ agent.class }}</td>
                  <td>{{ agent.status }}</td>
                  <td>{{ agent.agent_contact_info }}</td>
                  <td>{{ agent.agent_image }}</td>
                  <td>
                    <ul>
                      <li
                        v-for="project in agent.projects"
                        :key="project.id"
                      >{{ project.project_name }}</li>
                    </ul>
                  </td>
                  <td>{{ agent.created_at }}</td>
                  <td>{{ agent.updated_at }}</td>
                  <td>
                    <a href="#" @click="editModal(agent)">
                      <i class="fa fa-edit green pr-1"></i>
                    </a>
                    <a href="#" @click="addProjectModal(agent)">
                      <i class="fa yellow fa-plus"></i>
                    </a>
                    <a href="#" @click="deleteAgent(agent.id)">
                      <i class="fa red fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body meawww-->
          <div class="card-footer">
            <pagination :data="agents" @pagination-change-page="getResults"></pagination>
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
            <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New Agent</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update Agent Info</h5>
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
          <form @submit.prevent="editmode ? updateAgent() : createAgent()">
            <div class="modal-body">
              <div class="form-group">
                <label for="agentName">Agent's Name</label>
                <input v-model="form.agent_name" id="agentName" type="text" class="form-control" />
              </div>

              <div class="form-group">
                <label for="agentWebsite">Agent's Website</label>
                <input
                  v-model="form.agent_website"
                  id="agentWebsite"
                  type="text"
                  class="form-control"
                />
              </div>

              <div class="form-group">
                <label for="agentMainContactName">Agent's Main Contact Name</label>
                <input
                  v-model="form.agent_main_contact_name"
                  id="agentMainContactName"
                  type="text"
                  class="form-control"
                />
              </div>

              <div class="form-group">
                <label for="agentMoto">Agent's Moto</label>
                <input v-model="form.agent_moto" id="agentMoto" type="text" class="form-control" />
              </div>

              <div class="form-group">
                <label for="agentBusiness">Agent's Business</label>
                <input
                  v-model="form.agent_business"
                  id="agentBusiness"
                  type="text"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="agentProject">Agent's Project</label>
                <!-- <input v-model="agentMoto" id="agentMoto" class="form-control"> -->
                <select
                  v-model="form.agent_project"
                  name="agentProject"
                  class="form-control"
                  form="carform"
                >
                  <option
                    v-for="project in projectsList"
                    :key="project.id"
                    :value="project.id"
                    class="form-group"
                  >{{ project.project_name }}</option>
                </select>
              </div>

              <div class="form-group">
                <label for="agentTier">Agent's Tier</label>
                <!-- <input v-model="agentMoto" id="agentMoto" class="form-control"> -->
                <select
                  v-model="form.agent_tier"
                  name="agentTier"
                  class="form-control"
                  form="carform"
                >
                  <option
                    v-for="tier in tiersList"
                    :key="tier.id"
                    :value="tier.id"
                    class="form-group"
                  >{{ tier.tier_name }}</option>
                </select>
              </div>

              <div class="form-group">
                <label for="agentClass">Agent's Class</label>
                <!-- <input v-model="agentMoto" id="agentMoto" class="form-control"> -->
                <select
                  v-model="form.agent_class"
                  name="agentClass"
                  class="form-control"
                  form="carform"
                >
                  <option
                    v-for="clasaya in classList"
                    :key="clasaya.id"
                    :value="clasaya.id"
                    class="form-group"
                  >{{ clasaya.class_name }}</option>
                </select>
              </div>

              <div class="form-group">
                <label for="agentStatus">Agent Status</label>
                <!-- <input v-model="agentStatus" id="agentStatus" class="form-control"> -->
                <select
                  v-model="form.agent_status"
                  name="agentStatus"
                  class="form-control"
                  form="carform"
                >
                  <option
                    v-for="statusaya in statusList"
                    :key="statusaya.id"
                    :value="statusaya.id"
                    class="form-group"
                  >{{ statusaya.status_name }}</option>
                </select>
              </div>

              <div class="form-group">
                <label for="agentContactInfo">Contact info</label>
                <input
                  v-model="form.agent_contact_info"
                  id="agentContactInfo"
                  type="text"
                  class="form-control"
                />
              </div>

              <div class="form-group">
                <label for="agentImage">Agent's image</label>
                <input v-model="form.agent_image" id="agentImage" type="text" class="form-control" />
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Update User</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Create User</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Add Project Modal -->
    <div
      class="modal fade"
      id="addProject"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addProjectLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addProjectLabel">Add Project</h5>
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
          <form @submit.prevent="addProject()">
            <div class="modal-body">
              <div class="form-group">
                <label for="agentProject">Agent's Project</label>
                <!-- <input v-model="agentMoto" id="agentMoto" class="form-control"> -->
                <select
                  v-model="form.agent_project"
                  name="agentProject"
                  class="form-control"
                  form="carform"
                >
                  <option
                    v-for="project in projectsList"
                    :key="project.id"
                    :value="project.id"
                    class="form-group"
                  >{{ project.project_name }}</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Update Agent</button>
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
      agents: {},
      errorMsg: "",
      dismissSecs: 10,
      dismissCountDown: 0,
      statusList: [],
      projectsList: [],
      tiersList: [],
      classList: [],
      form: new Form({
        id: "",
        agent_name: "",
        agent_website: "",
        agent_main_contact_name: "",
        agent_moto: "",
        agent_business: "",
        agent_project: "",
        agent_tier: "",
        agent_class: "",
        agent_status: "",
        agent_contact_info: "",
        agent_image: ""
      })
    };
  },
  mounted() {
    axios.get("api/getTiers").then(({ data }) => (this.tiersList = data));
    axios.get("api/getStatus").then(({ data }) => (this.statusList = data));
    axios.get("api/getClass").then(({ data }) => (this.classList = data));
  },
  methods: {
    fetchProjectsData() {
      axios.get("api/getProjects").then(response => {
        this.projectsList = response.data;
      });
      // swal.fire("Failed", "Something wrong", "warning");
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getResults(page = 1) {
      axios.get("api/agent?page=" + page).then(response => {
        this.agents = response.data;
      });
    },
    updateAgent(id) {
      this.$Progress.start();
      this.form
        .put("api/agent/" + this.form.id)
        .then(() => {
          Fire.$emit("AfterAgentCreated");
          $("#addNew").modal("hide");
          swal.fire("Updated!", "Agent has been updated.", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          swal.fire("Failed", "Something wrong", "warning");

          this.$Progress.fail();
        });
    },
    addProject() {
      this.$Progress.start();
      axios
        .post("/api/addProjAgent/", {
          agent_project: this.form.agent_project,
          id: this.form.id
        })
        .then(response => {
          $("#addNew").modal("hide");
          swal.fire("Updated!", "Agent has been updated.", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          swal.fire("Failed", "Something wrong", "warning");

          this.$Progress.fail();
        });
    },
    editModal(agent) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(agent);
    },
    addProjectModal(agent) {
      this.form.reset();
      this.form.fill(agent);
      $("#addProject").modal("show");
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteAgent(id) {
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
              .delete("api/agent/" + id)
              .then(() => {
                Fire.$emit("AfterAgentCreated");

                swal.fire("Deleted!", "Your file has been deleted.", "success");
              })
              .catch(() => {
                swal.fire("Failed", "Something wrong", "warning");
              });
          }
        });
    },
    createAgent() {
      // Submit the form via a POST request
      this.$Progress.start();
      this.form
        .post("api/agent")
        .then(() => {
          Fire.$emit("AfterAgentCreated");
          $("#addNew").modal("hide");
          toast.fire({
            type: "success",
            title: "Agent Created successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    loadAgents() {
      if (this.$gate.isAdmin() || this.$gate.isUser()) {
        axios.get("api/agent").then(({ data }) => (this.agents = data));
      }
    },
    listenForChanges() {
      Echo.channel("agents").listen("AgentPublished", Agent => {
        this.loadAgents();
        this.showDismissibleAlert ? "visible" : "hidden";
      });
      Echo.channel("agents").listen("AgentRemoved", Agent => {
        this.loadAgents();
        this.showDismissibleAlert ? "visible" : "hidden";
      });
      Echo.channel("agents").listen("AgentUpdated", Agent => {
        this.loadAgents();
        this.showDismissibleAlert ? "visible" : "hidden";
      });
    }
  },

  created() {
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/FindAgent?q=" + query)
        .then(() => {
          this.agents = data.tata;
        })
        .catch(() => {
          swal.fire("Failed", "Something wrong", "warning");
        });
    });
    this.loadAgents();
    this.fetchProjectsData();
    Fire.$on("AfterAgentCreated", () => {
      this.loadAgents();
    });
    this.listenForChanges();
    // setInterval(()=>this.loadAgents(), 3000);
  }
};
</script>
