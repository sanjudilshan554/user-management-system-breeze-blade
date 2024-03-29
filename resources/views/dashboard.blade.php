@extends('layouts.app')
@section('content')

<div class="row">
    <h1>Admin Page</h1>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    {{-- <form action="javascript:void(0)" name="dashboard" id="dashboard" method="post">
        @csrf

        <div class="">
            <label for="">name</label>
            <input type="text" name="name" id="name">
        </div>
        <div class="">
            <label for="">email</label>
            <input type="email" name="email" id="email">
        </div>
        <div class="">
            <label for="">username</label>
            <input type="text" name="username" id="username">
        </div>
        <select id="usertype" name="usertype" class="form-select mt-1 block w-full">
            <option value="admin">Admin</option>
            <option value="superadmin">Super Admin</option>
            <option value="guest">Guest</option>
        </select>
        <div class="">
            <label for="">password</label>
            <input type="password" name="password" id="password">
        </div>

        <button type="submit" value="submit" id="submit">Submit</button>
    </form> --}}

</div>

<table id="userDataTable" class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>id</th>
            <th>username</th>
            <th>name</th>
            <th>email</th>
            <th>user type</th>
            <th>preview</th>
            <th>status</th>
            <th>action</th>

            <th><button class="sort-btn" data-sort-by="username">Sort by Username</button></th>
            <th><button class="sort-btn" data-sort-by="name">Sort by Name</button></th>
            <th><button class="sort-btn" data-sort-by="email">Sort by Email</button></th>
        </tr>
    </thead>

    <tbody>


    </tbody>

</table>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form action="javascript:void(0)" name="dashboard" id="dashboardUpdate" method="post">
                @csrf

                <input type="hidden" name="userId" id="userId">
                <div class="">
                    <label for="">name</label>
                    <input type="text" name="name" id="nameUpdate">
                </div>
                <div class="">
                    <label for="">email</label>
                    <input type="email" name="email" id="emailUpdate">
                </div>
                <div class="">
                    <label for="">username</label>
                    <input type="text" name="username" id="usernameUpdate">
                </div>
                <select id="usertypeUpdate" name="usertypeUpdate" class="form-select mt-1 block w-full">
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                    <option value="guest">Guest</option>
                </select>

                    <select id="statusUpdate" name="statusUpdate" class="form-select mt-1 block w-full">
                        <option value="0">deactive</option>
                        <option value="1">active</option>
                    </select>


                <button type="submit" value="submit" id="submit">Submit</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary close">Update</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {

        // Fetch user data when the document is ready
        fetchUserData();

        // Function to fetch user data
        function fetchUserData(sortBy = 'username') {
            $.ajax({
                url: "{{ route('user.get') }}"
                , type: "GET"
                , data: {
                    sortBy: sortBy
                }
                , success: function(response) {
                    var tableBody = $("#userDataTable tbody");
                    tableBody.empty(); // Clear existing rows

                    $.each(response, function(index, user) {
                        var row = '<tr>' +
                            '<td>' + (++index) + '</td>' +
                            '<td>' + user.id + '</td>' +
                            '<td>' + user.username + '</td>' +
                            '<td>' + user.name + '</td>' +
                            '<td>' + user.email + '</td>' +
                            '<td>' + user.user_type + '</td>' +
                            '<td>'+ '<button class="view" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-user-id="' + user.id + '">View</button>' +
                            '<td>' + user.status + '</td>' +
                            '<td>'+ '<button class="update" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-user-id="' + user.id + '">Update</button>' +
                                    '<button class="delete" data-user-id="' + user.id + '">Delete</button>' +
                            '</td>' +
                            '</tr>';
                        tableBody.append(row);
                    });
                }
                , error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $(document).on('click', ".view", function() {
    var userId = $(this).data("user-id");

    $('#exampleModal').modal('show');
    $('.close').hide();

    $.ajax({
        url: "{{ route('user.find') }}",
        type: "GET",
        data: {
            userId: $(this).data('user-id'),
        },
        success: function(response) {
            $('#nameUpdate').val(response.name);
            $('#emailUpdate').val(response.email);
            $('#usernameUpdate').val(response.username);
            $('#usertypeUpdate').val(response.user_type);
            $('#usertypeUpdate').trigger('change');
            $('#statusUpdate').val(response.status);
            $('#statusUpdate').trigger('change');
            $('#userId').val(response.id);
            // Set the switch checkbox based on the status received from the backend
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});


        $(document).on('click', ".update", function() {
    var userId = $(this).data("user-id");

    $('#exampleModal').modal('show');

    $.ajax({
        url: "{{ route('user.find') }}",
        type: "GET",
        data: {
            userId: $(this).data('user-id'),
        },
        success: function(response) {
            $('#nameUpdate').val(response.name);
            $('#emailUpdate').val(response.email);
            $('#usernameUpdate').val(response.username);
            $('#usertypeUpdate').val(response.user_type);
            $('#usertypeUpdate').trigger('change');
            $('#statusUpdate').val(response.status);
            $('#statusUpdate').trigger('change');
            $('#userId').val(response.id);
            // Set the switch checkbox based on the status received from the backend
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

        $(document).on('click', '.delete', function(){
            $.ajax({
                url:"{{ route('user.delete') }}",
                type:"GET",
                data:{
                    userId:$(this).data('user-id'),
                }, //all are the commas and semicolun are important 
                success: function(response){
                    fetchUserData();
                },
                error: function(xhr, status, error){
                    console.error(error);
                }

            });
        });

        $(document).on('click', '.sort-btn', function() {

            var sortBy = $(this).data('sort-by');

            // fetch user data
            $.ajax({
                url: "{{ route('user.get') }}"
                , type: "GET"
                , data: {
                    sortBy: sortBy
                }
                , success: function(response) {
                    var tableBody = $("#userDataTable tbody");
                    tableBody.empty(); //clear rows

                    $.each(response, function(index, user) {
                        var row = '<tr>' +
                            '<td>' + (++index) + '</td>' +
                            '<td>' + user.id + '</td>' +
                            '<td>' + user.username + '</td>' +
                            '<td>' + user.name + '</td>' +
                            '<td>' + user.email + '</td>' +
                            '<td>' + user.user_type + '</td>' +
                            '<td>' + '<button>preview</button>' + '</td>' +
                            '<td>' + user.status + '</td>' +
                            '</tr>';
                        tableBody.append(row);
                    });
                }
                , error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

  
                // form updation
                $("#dashboardUpdate").validate({
                        rules: {
                            nameUpdate: {
                    required: "Enter your name",
                    maxlength: "Not valid"
                },
                emailUpdate: {
                    required: "Enter your email",
                    maxlength: "Not valid",
                    email: "Enter a valid email" // Changed message for email validation
                },
                usernameUpdate: {
                    required: "Enter username",
                    maxlength: "Not valid"
                },
                    usertypeUpdate: {
                        required: true,
                        maxlength: 50
                    }
                },
                messages: {
                    nameUpdate: {
                        required: "Enter your name",
                        maxlength: "Not valid"
                    },
                    emailUpdate: {
                        required: "Enter your email",
                        maxlength: "Not valid",
                        email: "Enter a valid email" 
                    },
                    usernameUpdate: {
                        required: "Enter username",
                        maxlength: "Not valid"
                    },
                    usertypeUpdate: {
                        required: "Select user type",
                        maxlength: "Not valid"
                    }
                },
                    submitHandler: function(form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#submit').html('please wait..');
                    $('#submit').attr("disabled", true);

                    $.ajax({
                        url: "{{ route('user.update') }}",
                        type: "POST",
                        data: {
                            userId:$(this).data('user-id'),
                            formData: $('#dashboardUpdate').serialize()
                        },
                        success: function(response) {
                            $('#submit').html('Submit');
                            $('#submit').attr('disabled', false);
                            alert('Ajax form has been submitted successfully');
                            fetchUserData();
                            document.getElementById('dashboardUpdate').reset();
                        }
                    });
                }
            });
    });

</script>
@endsection
