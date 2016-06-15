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
                    <div class="panel-heading">Спринти</div>

                    <div class="panel-body">


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
                        <hr>
                        @if(
                        \Illuminate\Support\Facades\Auth::check()
                        && (\Illuminate\Support\Facades\Auth::User()->ruls == 1  //Если админ или Скрам менеджер то может редактировать.
                        || \Illuminate\Support\Facades\Auth::User()->ruls == 2))
                            <button type="button" class="btn btn-success" id="add-sprint">Додати спринт</button>
                        @endif
                        @if(isset($_GET['project_id']))
                            <a href="/sprint_gant?id={{$_GET['project_id']}}" type="button" class="btn btn-success" id="add-sprint">Діаграма ганта спринтів</a>
                        @endif

                            <hr>
                        <div class="row" style="margin-top: 10px;">
                            @foreach($sprints as $sprint)
                                <p style="margin-left: 10px;" class="pointer"
                                   onclick="changeSprint({{$sprint->id}})">{{$sprint->name}}
                                    : {{$sprint->time_start}} - {{$sprint->time_end}}</p>
                                {{--<hr>--}}
                                @if(
                            \Illuminate\Support\Facades\Auth::check()
                            && (\Illuminate\Support\Facades\Auth::User()->ruls == 1  //Если админ или Скрам менеджер то может редактировать.
                            || \Illuminate\Support\Facades\Auth::User()->ruls == 2))

                                    <button type="button" class="btn btn-success" onclick="addTask({{$sprint->id}})"
                                            id="add-task">Додати завдання
                                    </button>

                                @endif
                                <div class="sprint">


                                    <div class="col-md-4">

                                        <p>Нові завдання</p>
                                        <table id="open" class="display" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Назва</th>
                                                <th>Початок</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Назва</th>
                                                <th>Початок</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($tasks as $task)
                                                @if($task->sprint_id == $sprint->id && $task->progres == "open")
                                                    <tr>
                                                        <td onclick="loadTaskData({{$task->id}})" class="pointer">
                                                            <span id="task-{{$task->id}}" data-toggle="popover" title="Popover Header"
                                                                  data-content="Some content inside the popover">{{$task->name}}</span>
                                                        </td>
                                                        <td>
                                                            <span class="glyphicon glyphicon-chevron-right pointer" onclick="onWork({{$task->id}})"></span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div>


                                    <div class="col-md-4">
                                        <p>Завдання в роботі</p>
                                        <table id="work" class="display" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Назва</th>
                                                <th>Початок</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Назва</th>
                                                <th>Початок</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($tasks as $task)
                                                @if($task->sprint_id == $sprint->id && $task->progres == "work")
                                                    <tr>
                                                        <td onclick="loadTaskData({{$task->id}})" class="pointer">
                                                            <span id="task-{{$task->id}}" data-toggle="popover" title="Popover Header"
                                                                  data-content="Some content inside the popover">{{$task->name}}</span>
                                                        </td>
                                                        <td>
                                                            <span class="glyphicon glyphicon-chevron-right pointer" onclick="onFinish({{$task->id}})"></span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="col-md-4">


                                        <p>Завершенные</p>
                                        <table id="finish" class="display" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Назва</th>
                                                <th>Початок</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Назва</th>
                                                <th>Початок</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($tasks as $task)
                                                @if($task->sprint_id == $sprint->id && $task->progres == "finish")
                                                    <tr>
                                                        <td onclick="loadTaskData({{$task->id}})" class="pointer">
                                                            <span id="task-{{$task->id}}" data-toggle="popover" title="Popover Header"
                                                                  data-content="Some content inside the popover">{{$task->name}}</span>
                                                        </td>
                                                        <td>
                                                            <span class="glyphicon glyphicon-chevron-right pointer" onclick="onWork({{$task->id}})"></span>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <hr>
                                    </div>
                                </div>

                            @endforeach
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
                                    <form id="submit-form" method="post" action="{{url('/create/sprint')}}">
                                        {!! csrf_field() !!}
                                        <input name="id" id="id" type="hidden" value="">

                                        <label for="name">Назва</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder=""
                                               required>

                                        <label for="name">Опис</label>
                                        <textarea class="form-control" id="description" name="description"
                                                  required></textarea>

                                        <label for="description">Проект</label>
                                        <select id="select_project" class="form-control" name="select_project">
                                            @foreach($projects as $proj)
                                                <option value="{{$proj->id}}">{{$proj->name}}</option>
                                            @endforeach
                                        </select>

                                        <label for="name">Початок</label>
                                        <div class="form-group">
                                            <input class="form-control" id="time_start" onmouseover="picker(this)"
                                                   placeholder="Початок" name="time_start" required>
                                        </div>

                                        <label for="name">Кінець</label>
                                        <div class="form-group">
                                            <input class="form-control" id="time_end" onmouseover="picker(this)"
                                                   placeholder="Кінець" name="time_end" required>
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


                    {{-- 'name', 'description', 'time', 'type', 'priority', 'reopen', 'reopen_description' ,'creator_id', 'executor_id', 'sprint_id'--}}
                            <!-- Modal task -->
                    <div class="modal fade" id="myTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Завдання</h4>
                                </div>
                                <div class="modal-body">
                                    <p>* Всі поля обовязкові(Перевідкриття не обяз.)</p>
                                    <form id="submit-task" method="post" action="{{url('/create/task')}}">
                                        {!! csrf_field() !!}
                                        <input name="id" id="id" type="hidden" value="">
                                        <input name="sprint_id" id="sprint_id" type="hidden" value="">

                                        <label for="">Назва завдання</label>
                                        <input type="text" class="form-control" id="task_name" name="name"
                                               placeholder=""
                                               required>

                                        <label for="">Опис завдання</label>
                                        <textarea class="form-control" id="task_description" name="description"
                                                  required></textarea>

                                        <label for="">Час(в годинах)</label>
                                        <select id="time_task" class="form-control" name="time">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="8">8</option>
                                            <option value="16">16</option>
                                            <option value="24">24</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>

                                        <label for="">Час</label>
                                        <select id="type_task" class="form-control" name="type">
                                            <option value="develop">Розробка</option>
                                            <option value="test">Тестування</option>
                                            <option value="design">Проектування</option>
                                        </select>

                                        <label for="">Пріорітет</label>
                                        <select id="priority_task" class="form-control" name="priority">
                                            <option value="1">Високий</option>
                                            <option value="2">Середній</option>
                                            <option value="3">Низький</option>
                                        </select>

                                        <label for="">Виконавець</label>
                                        <select id="executor_id_task" class="form-control" name="executor_id">
                                            @foreach($users as $u)
                                                <option value="{{$u->id}}">{{$u->name}}</option>
                                            @endforeach
                                        </select>

                                        <label for="">Прогрес</label>
                                        <select id="progres_task" class="form-control" name="progres">
                                            <option value="open">Відкрито</option>
                                            <option value="work">В роботі</option>
                                            <option value="finish">Завершено</option>
                                        </select>

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="task_reopen" name="reopen"> Переоткрытое
                                            </label>
                                        </div>

                                        <label for="">Причина перевідкриття</label>
                                        <textarea class="form-control" id="task_reopen_description"
                                                  name="reopen_description"
                                        ></textarea>

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

        function changeSprint(id) {
            $.ajax({
                url: '/get/sprint',
                type: "get",
                data: {_token: token, id: id},
                success: function (data, textStatus) {
                    $('#submit-form').trigger('reset');
                    $('input#id').val(data.id);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#time_start').val(data.time_start);
                    $('#time_end').val(data.time_end);
                    $('#select_project option[value="' + data.project_id + '"]').prop('selected', 'selected').change();
                    $('#myModal').modal('show');
                },
                error: function (data, textStatus) {
                }
            });
        }

        $("#select_projector").change(function () {
            id = $(this).val()
            window.location = '/sprints/?project_id=' + id;
        });

        function addTask(id) {
            $('#sprint_id').val(id);
            $('#myTask').modal('show');
        }

        function loadTaskData(id) {
            /*$('[data-toggle="popover"]').each(function () {
               $(this).popover('hide');
            });*/

            $.ajax({
                url: '/loa/task',
                type: "post",
                data: {_token: token, id: id},
                success: function (data, textStatus) {
                    $('#task-'+id).attr('title', data.name);
                   $('#task-'+id).attr('data-content',
                            '<div>Описание:'+data.description+'</div>' +
                            '<div>Время:'+data.time+'</div>' +
                            '<div>Прогрес:'+data.progres+'</div>' +
                            '<div>Тип:'+data.type+'</div>'
                    );

                    $('#task-'+id).popover({
                        html: true,
                    });


                    $('#task-' + id).popover('show');

                },
                error: function (data, textStatus) {
                }
            });
        }

        function onWork(id) {
            $.ajax({
                url: '/work/task',
                type: "post",
                data: {_token: token, id: id},
                success: function (data, textStatus) {
                    location.reload();
                }
            });
        }

        function onFinish(id) {
            $.ajax({
                url: '/work/finish',
                type: "post",
                data: {_token: token, id: id},
                success: function (data, textStatus) {
                    location.reload();
                }
            });
        }
    </script>

    <script>$('.popover').popover()</script>

    <script>
     /*  $(document).ready(function () {
            $('[data-toggle="popover"]').popover();
        });*/
    </script>

@endsection
