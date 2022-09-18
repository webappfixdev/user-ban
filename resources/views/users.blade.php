@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
            @endif
            <div class="card">
                <div class="card-header text-center">
                    <h1>Users Management</h1>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Is Ban?</th>
                            <th>Action</th>
                        </tr>
                        @if($users->count())
                        @foreach($users as $key => $user)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->isBanned())
                                <label class="label label-danger">Yes</label>
                                @else
                                <label class="label label-success">No</label>
                                @endif
                            </td>
                            <td>
                                @if($user->isBanned())
                                <a href="{{ route('users.revokeuser',$user->id) }}" class="btn btn-success btn-sm"> Revoke</a>
                                @else
                                <a class="btn btn-success ban btn-sm" data-id="{{ $user->id }}" data-action="{{ URL::route('users.ban') }}"> Ban</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $("body").on("click",".ban",function(){


        var current_object = $(this);


        bootbox.dialog({

            message: "<form class='form-inline add-to-ban' method='POST'><div class='form-group'><textarea class='form-control reason' rows='4' placeholder='Add Reason for Ban this user.'></textarea></div></form>",

            title: "Add To Black List",

            buttons: {

                success: {

                label: "Submit",

                className: "btn-success",

                callback: function() {

                    var baninfo = $('.reason').val();
                    var token = $("input[name='_token']").val();
                    var action = current_object.attr('data-action');
                    var id = current_object.attr('data-id');

                    if(baninfo == ''){

                        $('.reason').css('border-color','red');

                        return false;

                    }else{

                        $('.add-to-ban').attr('action',action);
                        $('.add-to-ban').append('<input name="_token" type="hidden" value="'+ token +'">')
                        $('.add-to-ban').append('<input name="id" type="hidden" value="'+ id +'">')
                        $('.add-to-ban').append('<input name="baninfo" type="hidden" value="'+ baninfo +'">')
                        $('.add-to-ban').submit();

                    }

                }

            },

            danger: {

                label: "Cancel",

                className: "btn-danger",

                callback: function() {

                // remove

                }

            },

        }

    });

});

</script>
@endsection