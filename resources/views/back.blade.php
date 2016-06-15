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
                    <div class="panel-heading">Беклоги</div>

                    <div class="panel-body">
                        @if(
                        \Illuminate\Support\Facades\Auth::check()
                        && (\Illuminate\Support\Facades\Auth::User()->ruls == 1  //Если админ или Скрам менеджер то может редактировать.
                        || \Illuminate\Support\Facades\Auth::User()->ruls == 2))
                            <button type="button" class="btn btn-success" id="add-sprint">Додати беклог</button>
                        @endif

                        <hr>

                        <label for="description">Проект</label>
                        <select id="select_projector" class="form-control" name="select_project">
                            <option value="0">...</option>
                            @foreach($projects as $proj)
                                @if(isset($_GET['project_id']))
                                    <option @if($_GET['project_id'] == $proj->id) selected
                                            @endif value="{{$proj->id}}">{{$proj->name}}</option>
                                @else
                                    <option value="{{$proj->id}}">{{$proj->name}}</option>
                                @endif
                            @endforeach
                        </select>

                        <div class="row" style="margin-top: 10px;">

                                <hr>
                                @if(
                            \Illuminate\Support\Facades\Auth::check()
                            && (\Illuminate\Support\Facades\Auth::User()->ruls == 1  //Если админ или Скрам менеджер то может редактировать.
                            || \Illuminate\Support\Facades\Auth::User()->ruls == 2))


                                @endif
                                <div class="back">

                                    <div class="col-md-8">
                                        <p>Продукт беклог</p>
                                        <table id="open" class="display" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Назва</th>
                                                <th>Опис</th>
                                                <th>Важливість</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Назва</th>
                                                <th>Опис</th>
                                                <th>Важливість</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($backs as $back)
                                                    <tr>
                                                        <td onclick="changeBack({{$back->id}})" class="pointer">
                                                            <span id="task-{{$back->id}}">{{$back->name}}</span>
                                                        </td>
                                                        <td  class="pointer">
                                                            <span id="task-{{$back->id}}">{{$back->description}}</span>
                                                        </td>
                                                        <td class="pointer">
                                                            <span id="task-{{$back->id}}">{{$back->importan}}</span>
                                                        </td>
                                                        <td>
                                                            <span class="glyphicon glyphicon-minus pointer" onclick="deleteBack({{$back->id}})"></span>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>

                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Спринт</h4>
                                </div>
                                <div class="modal-body">
                                    <p>* Заповніть всі поля</p>
                                    <form id="submit-form" method="post" action="{{url('/create/back')}}">
                                        {!! csrf_field() !!}
                                        <input name="id" id="id" type="hidden" value="">

                                        <label for="name">Назва</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder=""
                                               required>

                                        <label for="name">Опис</label>
                                        <textarea class="form-control" id="description" name="description"
                                                  required></textarea>

                                        <label for="description">Проект</label>
                                        <select id="select_project" class="form-control" name="project_id">
                                            @foreach($projects as $proj)
                                                <option value="{{$proj->id}}">{{$proj->name}}</option>
                                            @endforeach
                                        </select>

                                        <label for="name">Важливість</label>
                                        <select id="importan" class="form-control" name="importan">
                                                <option value="important">Важное</option>
                                                <option value="no_important">Не важное</option>
                                                <option value="common">Обычное</option>
                                        </select>

                                        <label for="name">Час</label>
                                        <select id="time" class="form-control" name="time">
                                            <option value="0.5">0.5</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="4">4</option>
                                            <option value="8">8</option>
                                            <option value="24">24</option>
                                            <option value="100">100</option>
                                        </select>


                                        <label for="name">Бажаний результат</label>
                                        <div class="form-group">
                                            <input class="form-control" id="demo"
                                                   placeholder="Выбор конца спринта" name="demo" required>
                                        </div>
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
    {{-- </div>--}}

@endsection

@section('js')
    <script>
        token = $("input[name='_token']").val();

        $('#dateStart').datepicker({});
        $('#dateFinish').datepicker({});

        function picker(thisVal) {
            $(thisVal).datepicker({
                orientation: "bottom"
            });
        }

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

        $('#submit-task').on('submit', function (e) {
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

        function deleteBack(id) {
            $.ajax({
                url: '/delete/back',
                type: "post",
                data: {_token: token, id: id},
                success: function (data, textStatus) {
                    location.reload();
                },
                error: function (data, textStatus) {
                }
            });
        }



        function changeBack(id) {
            $.ajax({
                url: '/get/back',
                type: "get",
                data: {_token: token, id: id},
                success: function (data, textStatus) {
                    $('#submit-form').trigger('reset');
                    $('input#id').val(data.id);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    //$('#importan').val(data.importan);
                    $('#demo').val(data.demo);
                    $('#importan option[value="' + data.importan + '"]').prop('selected', 'selected').change();
                    $('#select_project option[value="' + data.project_id + '"]').prop('selected', 'selected').change();
                    $('#time option[value="' + data.time + '"]').prop('selected', 'selected').change();
                    $('#myModal').modal('show');
                },
                error: function (data, textStatus) {
                }
            });
        }

        $("#select_projector").change(function () {
            id = $(this).val()
            window.location = '/back/?project_id=' + id;
        });

</script>


@endsection
