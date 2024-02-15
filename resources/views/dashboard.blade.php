@extends('layouts.app')

@section('content')
<div class="row">
    <h1>Admin Page</h1>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <form action="javascript:void(0)" name="dashboard" id="dashboard" method="post">
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
            <label for="">password</label>
            <input type="password" name="password" id="password">
        </div>

        <button type="submit"  value="submit" id="submit">Submit</button>
    </form>

</div>


@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $("#dashboard").validate({
            rules:{
                name:{
                    required:true,
                    maxlength:50
                },
                email:{
                    required:true,
                    maxlength:50
                },
                password:{
                    required:true,
                    maxlength:6
                }
            },
            messages:{
                name:{
                    required:"enter your name",
                    maxlength:"not valid"
                },
                email:{
                    required:"enter your email",
                    maxlength:"not valid",
                    email:"not valid"
                },
                password:{
                    required:"enter your password",
                    maxlength:"not valid"
                }
            },
            submitHandler:function(form){
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#submit').html('please wait..');
                $('#submit').attr("disabled",true);

                $.ajax({
                    url: "{{ url('store') }}",
                    type: "POST",
                    data: $('#dashboard').serialize(),
                        success: function (response){
                        $('#submit').html('Submit');
                        $('#submit').attr('disabled',false);
                        alert('Ajax form has been submitted successfully');
                        document.getElementById('dashboard').rest();
                    }
                });
            }
        });
    });

</script>
@endsection