<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
              <h3 class="card-title">Task Assignment</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>Vendors</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="booking in bookings.data" :key="booking.id">
                    <td>{{ booking.id }}</td>
                    <td class="text-capitalize">{{ booking.name }}</td>
                    <td>
                        <span v-for="vendor in booking.vendors" :key="vendor.id" class="badge badge-success m-1">
                            {{vendor.name}}
                        </span>
                    </td>
                    <td>
                      <a href="#" @click="editModal(booking)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                      /
                      <a href="#" @click="deleteBooking(booking.id)">
                        <i class="fa fa-trash red"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination
                :data="bookings"
                @pagination-change-page="getResults"
              ></pagination>
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
        aria-labelledby="addNew"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" v-show="!editmode">Add New Task</h5>
              <h5 class="modal-title" v-show="editmode">Update Task</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editmode ? updateTask() : createBooking()">
              <div class="modal-body">
                <div class="form-group">
                    <label>Vendors</label>
                    <multiselect v-model="selectedVendors" :options="vendors" :multiple="true" track-by="id" label="name"></multiselect>
                    <has-error :form="form" field="vendor"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
                <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>

    import Multiselect from 'vue-multiselect'

    export default {

        components: { Multiselect },

        data() {
            return {
            editmode: false,
            bookings: {},
            vendors: [],
            selectedVendors: [],
            form: new Form({
                id: "",
                vendor_id: "",
            }),
            };
        },

        methods: {
            getResults(page = 1) {
            this.$Progress.start();
            axios
                .get("/api/assignment?page=" + page)
                .then(({ data }) => (this.bookings = data.data));

            this.$Progress.finish();
            },
            updateTask() {
                this.$Progress.start();
                this.form.vendor_id = this.selectedVendors;
                this.form
                    .put("/api/assignment/" + this.form.id)
                    .then((response) => {
                    $("#addNew").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                    this.$Progress.finish();
                    this.loadBookings();
                    })
                    .catch(() => {
                    this.$Progress.fail();
                    });
            },
            editModal(user) {
                this.editmode = true;
                this.form.reset();
                $("#addNew").modal("show");
                this.form.fill(user);
                this.loadSelectedVendors(this.form.id)
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $("#addNew").modal("show");
            },
            deleteBooking(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.value) {
                    this.form
                        .delete("/api/assignment/" + id)
                        .then(() => {
                        Swal.fire("Deleted!", "Your file has been deleted.", "success");
                        this.loadBookings();
                        })
                        .catch((data) => {
                        Swal.fire("Failed!", data.message, "warning");
                        });
                    }
                });
            },
            loadBookings() {
                this.$Progress.start();
                if (this.$gate.isAdmin()) {
                    axios.get("/api/assignment").then(({ data }) => (this.bookings = data.data));
                }
                this.$Progress.finish();
            },
            loadVendors() {
                this.$Progress.start();
                if (this.$gate.isAdmin()) {
                    axios.get("/api/getVendorsList").then(({ data }) => (this.vendors = data.data));
                }
                this.$Progress.finish();
            },
            createBooking() {
                this.form
                    .post("api/booking")
                    .then((response) => {
                    $("#addNew").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                    this.$Progress.finish();
                    this.loadBookings();
                    })
                    .catch(() => {
                    Toast.fire({
                        icon: "error",
                        title: "Some error occured! Please try again",
                    });
                });
            },

            loadSelectedVendors(id) {
                this.$Progress.start();
                if (this.$gate.isAdmin()) {
                    axios.get("/api/getSelectedVendors/" + id).then(({ data }) => (this.selectedVendors = data.data));
                }
                this.$Progress.finish();
            },
        },

        mounted() {
            console.log("BOOKING COMPONENT - SUCCESS");
        },

        created() {
            this.$Progress.start();
            this.loadVendors();
            this.loadBookings();
            this.$Progress.finish();
        },
    };
</script>
