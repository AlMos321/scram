@extends('layouts.app')

@section('content')
    <style>
        .pointer {
            cursor: pointer;
            color: #2ca02c;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome</div>

                    <div class="panel-body">
                        fsdfsdfsdf
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('js')
            <script>
                $(document).ready(function () {
                    $('#example').DataTable();
                });

                token = $("input[name='_token']").val();


                $('#add-sprint').on('click', function (e) {
                    $('#submit-form').trigger('reset');
                    $('input#id').val('');
                    $('#delete-btn').attr('delete-id', '');
                    $('#myModal').modal('show');
                });

                $('#submit-form').on('submit', function (e) {
                    e.preventDefault();
                    var url = $(this).attr('action');
                    var data = $(this).serialize();
                    $.ajax({
                        url: url,
                        type: "post",
                        data: data,
                        success: function (data, textStatus) {
                            location.reload();
                        },
                        error: function (data, textStatus) {
                        }
                    });
                });

                function changeProject(id) {
                    $.ajax({
                        url: '/get/project',
                        type: "get",
                        data: {_token: token, id: id},
                        success: function (data, textStatus) {
                            $('#submit-form').trigger('reset');
                            $('input#id').val(data.id);
                            $('#name').val(data.name);
                            $('#description').val(data.description);
                            $('#code').val(data.code);
                            $('#myModal').modal('show');
                        },
                        error: function (data, textStatus) {
                        }
                    });
                }
            </script>

@endsection
