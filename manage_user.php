<?php 
include('db_connect.php');
if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
?>
<style>
.eye{
    position:absolute;
}
</style>
<div class="container-fluid">
    
    <form action="" id="manage-user">
        <input type="hidden" id="hiddenID" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
        <u class="fw-bold text-primary text-center mt-3 mb-3"><h5 class="fw-bold text-primary text-center my-3">PERSONAL INFORMATION</h5></u>
        <div class="form-group">
            <!-- Default user image -->
            <img class="image-profile" style="cursor: pointer; display: block; width: 180px; height: 180px; margin: 0 auto; border-radius:50%;" src="<?= isset($meta['image']) ? $meta['image'] : './assets/img/defaultuser.png' ?>" alt="Profile Image">
            <input class="form-control mt-3" type="file" name="photo" id="photo" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" maxlength="55" class="form-control" value="<?php echo isset($meta['first_name']) ? $meta['first_name']: '' ?>" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" maxlength="55" class="form-control" value="<?php echo isset($meta['last_name']) ? $meta['last_name']: '' ?>" required>
        </div>
        <div class="form-group">
            <label for="user_contact">Contact Number</label>
            <input type="number" name="user_contact" id="user_contact" minlength="11" maxlength="11" class="form-control" value="<?php echo isset($meta['user_contact']) ? $meta['user_contact']: '' ?>" required>
        </div>
        <div class="form-group">
            <label for="user_address">Home Address</label>
            <input type="text" name="user_address" id="user_address" maxlength="195" class="form-control" value="<?php echo isset($meta['user_address']) ? $meta['user_address']: '' ?>" required>
        </div>
        
        <!-- New Email Field -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" maxlength="100" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required>
        </div>
        
        <u class="fw-bold text-primary text-center mt-3 mb-3"><h5 class="fw-bold text-primary text-center my-3">LOGIN CREDENTIALS</h5></u>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" maxlength="55" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" maxlength="55" class="form-control" value="<?php echo isset($meta['password']) ? $meta['password']: '' ?>" required>
            <label for="password">Show password</label>
            <input type="checkbox" id="showpass">
        </div>
        <div class="form-group">
            <label for="type">User Type</label>
            <select name="type" id="type" class="custom-select form-control">
                <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
                <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Staff</option>
            </select>
        </div>
        <div class="form-group row justify-content-between align-items-center">
             <div class="col-6">
                 <input type="submit" value="Save" class="btn btn-primary btn-block" id='submit'>
             </div>
             <div class="col-6">
                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancel</button>
             </div>
            
        </div>
    </form>
</div>
<script type="text/javascript">
    $(".image-profile").on('click', function()  {
        $('#photo').trigger('click');
    })
    $("#showpass").on('change', function(){
        if($("#password").attr('type') == 'password'){
            $("#password").attr('type', 'text')
        }
        else{
            $("#password").attr('type', 'password')
        }
    })
    if($("#modal-title").text() == 'Edit User' || $("#modal-title").text() == 'New User'){
        alert("Remove Modal Footer")
    }
</script>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.4.0/firebase-app.js";
  import { getStorage, listAll , ref, uploadBytesResumable, getDownloadURL } from "https://www.gstatic.com/firebasejs/9.4.0/firebase-storage.js";

  const firebaseConfig = {
      apiKey: "AIzaSyB7i3LT9kvNKfSqxddqG0kRkH0PFQVeYSk",
      authDomain: "laundrytech-b8bc1.firebaseapp.com",
      projectId: "laundrytech-b8bc1",
      storageBucket: "laundrytech-b8bc1.appspot.com",
      messagingSenderId: "741562650118",
      appId: "1:741562650118:web:399f7ae9afd15f9a0ebd87"
  };

  // Initialize Firebase
  const firebase = initializeApp(firebaseConfig);
  const storage = getStorage(firebase, 'gs://laundrytech-b8bc1.appspot.com');
  
    $('#manage-user').submit(function(e){
        e.preventDefault();
        start_load()
        const file = document.querySelector("#photo").files[0]

        if(file != null){
            const newUsername = $('#username').val();
            const storageFile = ref(storage, 'images/')
            var hasFolder = false;
            const imagesRef = ref(storage, 'images/' + newUsername)
            const metadata = {
                contentType: file.type
            }
            const task = uploadBytesResumable(imagesRef, file, metadata);
            task.on('state_changed', 
                (snapshot) => {
                    // Observe state change events such as progress, pause, and resume
                    const progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    console.log('Upload is ' + progress + '% done');
                    switch (snapshot.state) {
                    case 'paused':
                        console.log('Upload is paused');
                        break;
                    case 'running':
                        console.log('Upload is running');
                        break;
                    }
                }, 
                (err) => {
                    console.log("Upload error: " + err)
                }, 
                () => {
                    getDownloadURL(task.snapshot.ref).then((downloadURL) => {
                        $.ajax({
                            url: 'ajax.php?action=save_user',
                            method: 'POST',
                            dataType: "text",
                            data: { 
                                id: $("input[type='hidden']#hiddenID").val(),
                                first_name: $("#first_name").val(),
                                last_name: $("#last_name").val(),
                                user_contact: $("#user_contact").val(),
                                user_address: $("#user_address").val(),
                                email: $("#email").val(), // Added email field
                                username: $("#username").val(),
                                password: $("#password").val(),
                                image: downloadURL,
                                type: $("#type").val()
                            },
                            success: function(resp){
                                if(resp == 1){
                                    window.location = "./index.php?page=users"
                                } else {
                                    alert("Username already exists!");
                                }
                            }
                        })
                    });
                }
            );
        } else {
            $.ajax({
                url: 'ajax.php?action=save_user',
                method: 'POST',
                dataType: "text",
                data: { 
                    id: $("input[type='hidden']#hiddenID").val(),
                    first_name: $("#first_name").val(),
                    last_name: $("#last_name").val(),
                    user_contact: $("#user_contact").val(),
                    user_address: $("#user_address").val(),
                    email: $("#email").val(), // Added email field
                    username: $("#username").val(),
                    password: $("#password").val(),
                    image: '',
                    type: $("#type").val()
                },
                success: function(resp){
                    if(resp == 1){
                        window.location = "./index.php?page=users"
                    } else {
                        alert("Username already exists!");
                    }
                }
            })
        }
    })
</script>
