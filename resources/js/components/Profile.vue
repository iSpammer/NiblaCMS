<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12 mt-3">
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background-image:url('./img/user-cover.jpg')"
          >
            <h3 class="widget-user-username">{{form.name}}</h3>
            <h5 class="widget-user-desc">{{form.bio}}</h5>
          </div>
          <div class="widget-user-image">
            <img v-if="!isPhotoChanged" class="img-circle" :src="getProfilePicture()" alt="User Avatar" />
            <img v-if="is_photo_changed" class="img-circle" :src="form.photo" alt="User Avatar" />
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">3,200</h5>
                  <span class="description-text">SALES</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">13,000</h5>
                  <span class="description-text">FOLLOWERS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">35</h5>
                  <span class="description-text">PRODUCTS</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img v-if="!isPhotoChanged" class="img-circle w-100" :src="getProfilePicture()" :alt="none" />
                    <img v-if="isPhotoChanged" class="img-circle w-100" :src="form.photo" :alt="none" />
                  </div>
                  <h3 class="profile-username text-center">{{form.name}}</h3>
                  <p class="text-muted text-center">Software Engineer</p>
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Followers</b>
                      <a class="float-right">1,322</a>
                    </li>
                    <li class="list-group-item">
                      <b>Following</b>
                      <a class="float-right">543</a>
                    </li>
                    <li class="list-group-item">
                      <b>Friends</b>
                      <a class="float-right">13,287</a>
                    </li>
                  </ul>
                  <a href="#" class="btn btn-primary btn-block">
                    <b>Follow</b>
                  </a>
                </div>
              </div>
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">About Me</h3>
                </div>
                <div class="card-body">
                  <strong>
                    <i class="fas fa-book mr-1"></i> Education
                  </strong>
                  <p
                    class="text-muted"
                  >B.S. in Computer Science from the University of Tennessee at Knoxville</p>
                  <hr />
                  <strong>
                    <i class="fas fa-map-marker-alt mr-1"></i> Location
                  </strong>
                  <p class="text-muted">Malibu, California</p>
                  <hr />
                  <strong>
                    <i class="fas fa-pencil-alt mr-1"></i> Skills
                  </strong>
                  <p class="text-muted">
                    <span class="tag tag-danger">UI Design</span>
                    <span class="tag tag-success">Coding</span>
                    <span class="tag tag-info">Javascript</span>
                    <span class="tag tag-warning">PHP</span>
                    <span class="tag tag-primary">Node.js</span>
                  </p>
                  <hr />
                  <strong>
                    <i class="far fa-file-alt mr-1"></i> Notes
                  </strong>
                  <p
                    class="text-muted"
                  >Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                </div>
              </div>
            </div>
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item">
                      <a href="#activity" data-toggle="tab" class="nav-link active">Activity</a>
                    </li>
                    <li class="nav-item">
                      <a href="#timeline" data-toggle="tab" class="nav-link">Timeline</a>
                    </li>
                    <li class="nav-item">
                      <a href="#settings" data-toggle="tab" class="nav-link">Settings</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div id="activity" class="tab-pane active">
                      <div class="post">
                        <div class="user-block">
                          <img
                            src="/img/user.png"
                            alt="user image"
                            class="img-circle img-bordered-sm"
                          />
                          <span class="username">
                            <a href="#">Jonathan Burke Jr.</a>
                            <a href="#" class="float-right btn-tool">
                              <i class="fas fa-times"></i>
                            </a>
                          </span>
                          <span class="description">Shared publicly - 7:30 PM today</span>
                        </div>
                        <p>
                          Lorem ipsum represents a long-held tradition for designers,
                          typographers and the like. Some people hate it and argue for
                          its demise, but others ignore the hate as they create awesome
                          tools to help create filler text for everyone from bacon lovers
                          to Charlie Sheen fans.
                        </p>
                        <p>
                          <a href="#" class="link-black text-sm mr-2">
                            <i class="fas fa-share mr-1"></i> Share
                          </a>
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-thumbs-up mr-1"></i> Like
                          </a>
                          <span class="float-right">
                            <a href="#" class="link-black text-sm">
                              <i class="far fa-comments mr-1"></i> Comments (5)
                            </a>
                          </span>
                        </p>
                        <input
                          type="text"
                          placeholder="Type a comment"
                          class="form-control form-control-sm"
                        />
                      </div>
                      <div class="post clearfix">
                        <div class="user-block">
                          <img
                            src="/img/user.png"
                            alt="User Image"
                            class="img-circle img-bordered-sm"
                          />
                          <span class="username">
                            <a href="#">Sarah Ross</a>
                            <a href="#" class="float-right btn-tool">
                              <i class="fas fa-times"></i>
                            </a>
                          </span>
                          <span class="description">Sent you a message - 3 days ago</span>
                        </div>
                        <p>
                          Lorem ipsum represents a long-held tradition for designers,
                          typographers and the like. Some people hate it and argue for
                          its demise, but others ignore the hate as they create awesome
                          tools to help create filler text for everyone from bacon lovers
                          to Charlie Sheen fans.
                        </p>
                        <form class="form-horizontal">
                          <div class="input-group input-group-sm mb-0">
                            <input placeholder="Response" class="form-control form-control-sm" />
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-danger">Send</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="post">
                        <div class="user-block">
                          <img
                            src="/img/user.png"
                            alt="User Image"
                            class="img-circle img-bordered-sm"
                          />
                          <span class="username">
                            <a href="#">Adam Jones</a>
                            <a href="#" class="float-right btn-tool">
                              <i class="fas fa-times"></i>
                            </a>
                          </span>
                          <span class="description">Posted 5 photos - 5 days ago</span>
                        </div>
                        <div class="row mb-3">
                          <div class="col-sm-6">
                            <img src="/img/user.png" alt="Photo" class="img-fluid" />
                          </div>
                          <div class="col-sm-6">
                            <div class="row">
                              <div class="col-sm-6">
                                <img src="/img/user.png" alt="Photo" class="img-fluid mb-3" />
                                <img src="/img/user.png" alt="Photo" class="img-fluid" />
                              </div>
                              <div class="col-sm-6">
                                <img src="/img/user.png" alt="Photo" class="img-fluid mb-3" />
                                <img src="/img/user.png" alt="Photo" class="img-fluid" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <p>
                          <a href="#" class="link-black text-sm mr-2">
                            <i class="fas fa-share mr-1"></i> Share
                          </a>
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-thumbs-up mr-1"></i> Like
                          </a>
                          <span class="float-right">
                            <a href="#" class="link-black text-sm">
                              <i class="far fa-comments mr-1"></i> Comments (5)
                            </a>
                          </span>
                        </p>
                        <input
                          type="text"
                          placeholder="Type a comment"
                          class="form-control form-control-sm"
                        />
                      </div>
                    </div>
                    <div id="timeline" class="tab-pane">
                      <div class="timeline timeline-inverse">
                        <div class="time-label">
                          <span class="bg-danger">10 Feb. 2014</span>
                        </div>
                        <div>
                          <i class="fas fa-envelope bg-primary"></i>
                          <div class="timeline-item">
                            <span class="time">
                              <i class="far fa-clock"></i> 12:05
                            </span>
                            <h3 class="timeline-header">
                              <a href="#">Support Team</a> sent you an email
                            </h3>
                            <div class="timeline-body">
                              Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                              weebly ning heekya handango imeem plugg dopplr jibjab, movity
                              jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                              quora plaxo ideeli hulu weebly balihoo...
                            </div>
                            <div class="timeline-footer">
                              <a href="#" class="btn btn-primary btn-sm">Read more</a>
                              <a href="#" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                          </div>
                        </div>
                        <div>
                          <i class="fas fa-user bg-info"></i>
                          <div class="timeline-item">
                            <span class="time">
                              <i class="far fa-clock"></i> 5 mins ago
                            </span>
                            <h3 class="timeline-header border-0">
                              <a href="#">Sarah Young</a> accepted your friend request
                            </h3>
                          </div>
                        </div>
                        <div>
                          <i class="fas fa-comments bg-warning"></i>
                          <div class="timeline-item">
                            <span class="time">
                              <i class="far fa-clock"></i> 27 mins ago
                            </span>
                            <h3 class="timeline-header">
                              <a href="#">Jay White</a> commented on your post
                            </h3>
                            <div class="timeline-body">
                              Take me to your leader!
                              Switzerland is small and neutral!
                              We are more like Germany, ambitious and misunderstood!
                            </div>
                            <div class="timeline-footer">
                              <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                            </div>
                          </div>
                        </div>
                        <div class="time-label">
                          <span class="bg-success">3 Jan. 2014</span>
                        </div>
                        <div>
                          <i class="fas fa-camera bg-purple"></i>
                          <div class="timeline-item">
                            <span class="time">
                              <i class="far fa-clock"></i> 2 days ago
                            </span>
                            <h3 class="timeline-header">
                              <a href="#">Mina Lee</a> uploaded new photos
                            </h3>
                            <div class="timeline-body">
                              <img src="http://placehold.it/150x100" alt="..." />
                              <img src="http://placehold.it/150x100" alt="..." />
                              <img src="http://placehold.it/150x100" alt="..." />
                              <img src="http://placehold.it/150x100" alt="..." />
                            </div>
                          </div>
                        </div>
                        <div>
                          <i class="far fa-clock bg-gray"></i>
                        </div>
                      </div>
                    </div>
                    <div id="settings" class="tab-pane">
                      <form @submit.prevent="updateInfo()" class="form-horizontal">
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input
                              v-model="form.name"
                              type="text"
                              id="inputName"
                              placeholder="Name"
                              class="form-control"
                              :class="{ 'is-invalid': form.errors.has('name') }"
                            />
                            <has-error :form="form" field="name"></has-error>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input
                              v-model="form.email"
                              type="email"
                              id="inputEmail"
                              placeholder="Email"
                              class="form-control"
                              :class="{ 'is-invalid': form.errors.has('email') }"
                            />\
                            <has-error :form="form" field="email"></has-error>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputBio" class="col-sm-2 col-form-label">Bio</label>
                          <div class="col-sm-10">
                            <textarea
                              v-model="form.bio"
                              type="text"
                              id="inputBio"
                              placeholder="Bio"
                              class="form-control"
                            ></textarea>
                          </div>
                        </div>
                        <!-- <div class="form-group row">
                          <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                          <div class="col-sm-10">
                            <textarea
                              id="inputExperience"
                              placeholder="Experience"
                              class="form-control"
                            ></textarea>
                          </div>
                        </div>-->
                        <div class="form-group row">
                          <label
                            for="inputProfilePicture"
                            class="col-sm-2 col-form-label"
                          >ProfilePicture</label>
                          <div class="col-sm-10">
                            <input
                              type="file"
                              @change="updateProfile"
                              id="inputProfilePicture"
                              class="form-control"
                            />
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                          <div class="col-sm-10">
                            <input
                              v-model="form.password "
                              type="text"
                              id="inputPassword"
                              placeholder="Password"
                              class="form-control"
                              :class="{ 'is-invalid': form.errors.has('password') }"
                            />
                            <has-error :form="form" field="password"></has-error>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" /> I agree to the
                                <a href="#">terms and conditions</a>
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Update</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<style>
.widget-user-header {
  background-position: center center;
  background-size: cover;
}
</style>

<script>
export default {
  data() {
    return {
      form: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: "",
        isPhotoChanged: false,
      })
    };
  },
  mounted(){
    console.log("Component mounted.");
  },
  created() {
    this.loadProfile();
     Fire.$on("ProfileUpdated", () => {
      this.loadUsers();
    });
  },
  methods: {
    loadProfile(){
        axios.get("api/profile").then(({ data }) => {
      this.form.fill(data);
    });
    },
    getProfilePicture() {
        let prefix = (this.form.photo.match(/\//) ? '' : '/img/profile/');
        return prefix + this.form.photo;
       // return "/img/profile/"+this.form.photo;
    },
    updateInfo() {
      this.$Progress.start();
      this.form
        .put("api/profile/")
        .then(() => {
          Fire.$emit("ProfileUpdated");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    updateProfile(e) {
      let file = e.target.files[0];
      //   console.log(file)
      let reader = new FileReader();
      if (file["size"] < 2111775) {
        reader.onloadend = file => {
          console.log("RESULT");
          this.form.photo = reader.result;
          this.isPhotoChanged = true;
        };

        reader.readAsDataURL(file);
      } else {
        swal.fire({
          type: "error",
          title: "Oops....",
          text: "You were trying to upload large files"
        });
      }
    }
  }
};
</script>
