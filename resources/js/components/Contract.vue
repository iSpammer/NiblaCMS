<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Contracts</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal()">
                Add new
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead class="">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th>description</th>
                  <th>Created at</th>
                  <th>Updated at</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="contract in contracts.data" :key="contract.id">
                  <td>{{ contract.id }}</td>
                  <td>{{ contract.contract_name }}</td>
                  <td>{{ contract.contract_start_date }}</td>
                  <td>{{ contract.contract_end_date }}</td>
                  <td>{{ contract.contract_status }}</td>
                  <td>{{ contract.contract_description }}</td>
                  <td>{{ contract.created_at }}</td>
                  <td>{{ contract.updated_at }}</td>
                  <td>
                    <a href="#" @click="editModal(contract)">
                      <i class="fa fa-edit green pr-1"></i>
                    </a>
                    <a href="#" @click="deleteContract(contract.id)">
                      <i class="fa red fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body meawww-->
          <div class="card-footer">
            <pagination :data="contracts" @pagination-change-page="getResults"></pagination>
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
            <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New Contract</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update Contract Info</h5>
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
          <form @submit.prevent="editmode ? updateContract() : createContract()">
            <div class="modal-body">
              <div class="form-group">
                <label for="contractName">Contract Name</label>
                <input
                  v-model="form.contract_name"
                  id="contractName"
                  type="text"
                  class="form-control"
                />
              </div>

              <!-- <div class="form-group">
          <label for="contractEndDate">Contract End Date</label>
          <input v-model="contractEndDate" id="contractEndDate" class="form-control">
              </div>-->

              <div class="container">
                <div class="row">
                  <div class="col-sm form-group">
                    <label for="contractStartDate">Contract Start Date</label>
                    <input
                      v-model="form.contract_start_date"
                      type="date"
                      id="contractStartDate"
                      class="form-control"
                    />
                  </div>
                  <div class="col-sm form-group">
                    <label for="contractEndDate">Contract End Date</label>
                    <input
                      v-model="form.contract_end_date"
                      class="form-control"
                      type="date"
                      id="start"
                      name="contractEndDate"
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
                <label for="contractStatus">Contract Status</label>
                <!-- <input v-model="contractStatus" id="contractStatus" class="form-control"> -->
                <select
                  v-model="form.contract_status"
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
                <label for="contractDescription">Contract Description</label>
                <input
                  v-model="form.contract_description"
                  id="contractDescription"
                  class="form-control"
                />
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
  </div>
</template>
<script>
export default {
  data() {
    return {
      editmode: true,
      contracts: {},
      errorMsg: "",
      dismissSecs: 10,
      dismissCountDown: 0,
      statusList: [],
      form: new Form({
        id: 0,
        contract_name: "",
        contract_start_date: "",
        contract_end_date: "",
        contract_status: "",
        contract_description: ""
      })
    };
  },
  mounted() {
    axios.get("api/getStatus").then(({ data }) => (this.statusList = data));
  },
  methods: {
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    getResults(page = 1) {
      axios.get("api/contract?page=" + page).then(response => {
        this.contracts = response.data;
      });
    },
    updateContract(id) {
      if (this.form.contract_start_date > this.form.contract_end_date) {
        this.showAlert();
        this.errorMsg = "Start date cannot be less than end date";
        this.showDismissibleAlert ? true : false;
        return;
      }
      this.$Progress.start();
      this.form
        .put("api/contract/" + this.form.id)
        .then(() => {
          Fire.$emit("AfterContractCreated");
          $("#addNew").modal("hide");
          swal.fire("Updated!", "Contract has been updated.", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          swal.fire("Failed", "Something wrong", "warning");

          this.$Progress.fail();
        });
    },
    editModal(contract) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(contract);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteContract(id) {
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
              .delete("api/contract/" + id)
              .then(() => {
                Fire.$emit("AfterContractCreated");

                swal.fire("Deleted!", "Your file has been deleted.", "success");
              })
              .catch(() => {
                swal.fire("Failed", "Something wrong", "warning");
              });
          }
        });
    },
    createContract() {
      if (this.form.contract_start_date > this.form.contract_end_date) {
        this.showAlert();
        this.errorMsg = "Start date cannot be less than end date";
        this.showDismissibleAlert ? true : false;
        return;
      }
      // Submit the form via a POST request
      this.$Progress.start();
      this.form
        .post("api/contract")
        .then(() => {
          Fire.$emit("AfterContractCreated");
          $("#addNew").modal("hide");
          toast.fire({
            type: "success",
            title: "Contract Created successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    loadContracts() {
      if (this.$gate.isAdmin() || this.$gate.isUser()) {
        axios.get("api/contract").then(({ data }) => (this.contracts = data));
        console.log("meaw");
        console.log(this.contracts);
      }
    },
    listenForChanges() {
      Echo.channel("contracts").listen("ContractPublished", Contract => {
        this.loadContracts();
        this.showDismissibleAlert ? "visible" : "hidden";
      });
      Echo.channel("contracts").listen("ContractRemoved", Contract => {
        this.loadContracts();
        this.showDismissibleAlert ? "visible" : "hidden";
      });
      Echo.channel("contracts").listen("ContractUpdated", Contract => {
        this.loadContracts();
        this.showDismissibleAlert ? "visible" : "hidden";
      });
    }
  },

  created() {
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/FindContract?q=" + query)
        .then(() => {
          this.contracts = data.tata;
        })
        .catch(() => {
          swal.fire("Failed", "Something wrong", "warning");
        });
    });
    this.loadContracts();
    Fire.$on("AfterContractCreated", () => {
      this.loadContracts();
    });
    this.listenForChanges();

    // setInterval(()=>this.loadContracts(), 3000);
  }
};
</script>
