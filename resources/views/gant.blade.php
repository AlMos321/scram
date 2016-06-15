<!DOCTYPE html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Basic initialization</title>
</head>
<script src="/codebase/dhtmlxgantt.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="/codebase/dhtmlxgantt.css" type="text/css" media="screen" title="no title" charset="utf-8">

<script type="text/javascript" src="/common/testdata.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"
        integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<style type="text/css">
    html, body{ height:100%; padding:0px; margin:0px; overflow: hidden;}
</style>
{!! csrf_field() !!}
<body>
<div id="gantt_here" style='width:100%; height:100%;'></div>
<script type="text/javascript">

    token = $("input[name='_token']").val();
    changeBack({{$_GET['id']}});
    function changeBack(id) {
        $.ajax({
            url: '/get/gant',
            type: "get",
            data: {_token: token, id: id},
            success: function (data, textStatus) {
                //console.log(data)
               // console.log(tasks)
                gantt.init("gantt_here");
                gantt.parse(data);
            }
        });
    }


    var tasks =  {
        data:[
            {id:1, text:"Project #2", start_date:"06/06/2016", duration:10,order:1, progress:0.4, open: true},
            {id:2, text:"Task #1", 	  start_date:"06/06/2016", duration:8, order:10, progress:0.6, parent:1},
            {id:3, text:"Task #2",    start_date:"06/06/2016", duration:8, order:20, progress:0.6, parent:1},

            {id:4, text:"Project #3", start_date:"06-15-2016", duration:10,order:1, progress:0.4, open: true},
            {id:5, text:"Task #1", 	  start_date:"06-06-2016", duration:8, order:10, progress:0.6, parent:4},
            {id:6, text:"Task #2",    start_date:"06-06-2016", duration:8, order:20, progress:0.6, parent:4}

        ],
        /*links:[
            { id:1, source:1, target:2, type:"1"},
            { id:2, source:2, target:3, type:"0"},
            { id:3, source:3, target:4, type:"0"},
            { id:4, source:2, target:5, type:"2"},
        ]*/
    };

    $('#text').text('Назва');

    /*gantt.init("gantt_here");


    gantt.parse(tasks);*/

</script>
</body>