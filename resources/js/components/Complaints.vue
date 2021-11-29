<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
              <h3 class="card-title">Complaints List</h3>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="complaint in complaints.data" :key="complaint.id">
                    <td>{{ complaint.id }}</td>
                    <td class="text-capitalize">{{ complaint.name }}</td>
                    <td>{{ complaint.email }}</td>
                    <td>{{ complaint.phone }}</td>
                    <td>{{ complaint.message }}</td>
                    <td>
                      <a href="#" @click="deleteComplaint(complaint.id)">
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
                :data="complaints"
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
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      editmode: false,
      complaints: {},
      form: new Form({
        id: "",
      }),
    };
  },

  methods: {
    getResults(page = 1) {
      this.$Progress.start();

      axios
        .get("api/complaint?page=" + page)
        .then(({ data }) => (this.complaints = data.data));

      this.$Progress.finish();
    },
    deleteComplaint(id) {
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
            .delete("api/complaint/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.loadComplaints();
            })
            .catch((data) => {
              Swal.fire("Failed!", data.message, "warning");
            });
        }
      });
    },
    loadComplaints() {
      this.$Progress.start();
      if (this.$gate.isAdmin()) {
        axios.get("api/complaint").then(({ data }) => (this.complaints = data.data));
      }
      this.$Progress.finish();
    },
    createUser() {
      this.form
        .post("api/complaint")
        .then((response) => {
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.$Progress.finish();
          this.loadComplaints();
        })
        .catch(() => {
          Toast.fire({
            icon: "error",
            title: "Some error occured! Please try again",
          });
        });
    },
  },

  mounted() {
    console.log("COMPLAINTS COMPONENT - SUCCESS");
  },

  created() {
    this.$Progress.start();
    this.loadComplaints();
    this.$Progress.finish();
  },
};
</script>
