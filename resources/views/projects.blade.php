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
                    <div class="panel-heading">Проект</div>

                    <div class="panel-body">
                        @if(
                        \Illuminate\Support\Facades\Auth::check()
                        && (\Illuminate\Support\Facades\Auth::User()->ruls == 1  //Если админ или Скрам менеджер то может редактировать.
                        || \Illuminate\Support\Facades\Auth::User()->ruls == 2))
                            <button type="button" class="btn btn-success" id="add-sprint">Додати проект</button>
                        @endif
                            <hr>
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Назва</th>
                                    <th>Опис</th>
                                    <th>Код проекта</th>
                                    <th>Видалити</th>
                                    <th>Ганта</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Назва</th>
                                    <th>Опис</th>
                                    <th>Код проекта</th>
                                    <th>Видалити</th>
                                    <th>Ганта</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td onclick="changeProject({{$project->id}})" class="pointer">{{$project->name}}</td>
                                    <td>{{$project->description}}</td>
                                    <td>{{$project->code}}</td>
                                    <td onclick="deleteProject({{$project->id}})"><span class="glyphicon glyphicon-minus-sign pointer"></span></td>
                                    <td><a href="/gant?id={{$project->id}}">Ганта діаграма</a></td>
                                </tr>
                                </tbody>
                                @endforeach
                            </table>

                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Проекты</h4>
                                </div>
                                <div class="modal-body">
                                    <p>* Заповніть всі поля</p>
                                    <form id="submit-form" method="post" action="{{url('/create/project')}}">
                                        {!! csrf_field() !!}
                                        <input name="id" id="id" type="hidden" value="">

                                        <label for="name">Назва проекта</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder=""
                                               required>
                                        <label for="code">Кодова назва проекта</label>
                                        <input type="text" class="form-control" id="code" name="code" placeholder=""
                                               required>

                                        <label for="description">Опис проекта</label>
                                        <textarea class="form-control" id="description" name="description"
                                                  required></textarea>

                                        <label for="name">Початок</label>
                                        <div class="form-group">
                                            <input class="form-control" id="time_start" onmouseover="picker(this)"
                                                   placeholder="Початок проекту" name="time_start" required>
                                        </div>

                                        <label for="name">Кінець</label>
                                        <div class="form-group">
                                            <input class="form-control" id="time_end" onmouseover="picker(this)"
                                                   placeholder="Кінець проекту" name="time_end" required>
                                        </div>
                                        <br>
                                        @if(
                   \Illuminate\Support\Facades\Auth::check()
                   && (\Illuminate\Support\Facades\Auth::User()->ruls == 1  //Если админ или Скрам менеджер то может редактировать.
                   || \Illuminate\Support\Facades\Auth::User()->ruls == 2))
                                            <button type="submit" class="btn btn-primary">Зберегти</button>
                                        @endif
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button btn-primary" class="btn btn-default" data-dismiss="modal">
                                        Закрити
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('js')



    <script>


        $('#dateStart').datepicker({});
        $('#dateFinish').datepicker({});

        function picker(thisVal) {
            $(thisVal).datepicker({
                orientation: "bottom"
            });
        }

        $(document).ready(function() {
            $('#example').DataTable( {
                "language": {
                    "search": "Пошук",
                    "info":           "Показано _START_ - _END_ из _TOTAL_ записів",
                    "infoEmpty":      "Показано 0 - 0 із 0 записів",
                    "lengthMenu":     "Показано _MENU_ записів",
                    "paginate": {
                        "previous": "Попередня",
                        "next": "Наступна"
                    },
                    "zeroRecords": "Нічого не знайдено",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            } );
        } );

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
                    $('#time_start').val(data.time_start);
                    $('#time_end').val(data.time_end);
                    $('#myModal').modal('show');
                },
                error: function (data, textStatus) {
                }
            });
        }

        function deleteProject(id) {
            $.ajax({
                url: '/delete/project',
                type: "post",
                data: {_token: token, id: id},
                success: function (data, textStatus) {
                    location.reload();
                },
                error: function (data, textStatus) {
                }
            });
        }
    </script>

@endsection
