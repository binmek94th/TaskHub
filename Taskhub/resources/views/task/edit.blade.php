<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task</title>
    <style>
        h3{
            color: white;
            font-size: 26px !important;
            font-weight: bold !important;
            padding-bottom: 20px;
        }
        h4{
            font-size: 22px !important;
            font-weight: bold !important;
            margin-bottom: 10px !important;
        }
        .form{
            color: white;
            display: flex;
            width: 100%;
        }
        .first-side{
            width: 50%;
        }
        .first-side ul{
            margin-top: 10px;
            margin-left: 50px;
        }
        .first-side li{
            list-style: disc;
        }
        .second-side{
            width: 50%;
            margin-right: 150px;
        }
        .main{
            margin-left: 200px;
            margin-top: 70px;
        }
        input[type= text]{
            margin-top: 10px;
            color: black;
            margin-bottom: 10px;
            border-radius: 15px;
            width: 300px;
        }
        input[type= date]{
            color: black;
            margin-top: 10px;
            margin-bottom: 10px;
            border-radius: 15px;
            width: 300px;
        }
        input[type="submit"]{
            margin-top: 50px;
            width: 100px;
            height: 40px;
            background-color: #6774f3;
            border-radius: 15px;
            cursor: pointer;
            margin-left: 85%;
        }
        input[type="submit"]:hover{
            background-color: #7f8ae8;
        }
        .add-sub-tag {
            margin-top: 10px;
            font-size: 20px;
        }

        /* Style for subtag input */
        .subtag input {
            margin-top: 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            padding: 10px;
            width: 200px;
            height: 30px;
        }
        .box{
            background-color: #1c233a;
            margin-top: 20px;
            width: 70%;
            height: 300px;
            border-radius: 15px;
            padding-top: 10px;
        }
        .circle{
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #6774f3;
        }
        .line{
            position: relative;
            left: 6px;
            width: 2px;
            height: 50px;
            background-color: #6774f3;
        }
        .canvas{
            margin: 20px;
        }
        .radio{
            display: flex;
        }
        .radio input[type=checkbox]{
            margin-right: 10px;
        }

        .radio P{
            margin-top: -5px;
            margin-bottom: 10px;
        }
        #clearSelection {
            width: 60px;
            margin-left: 25%;
            height: 30px;
            background-color: #1c233a;
            border-radius: 15px;
            cursor: pointer;
        }

        #clearSelection:hover {
            background-color: #2a3350;
        }
        .sub-tag-head{
            display: flex;
        }
        .update-btn{
            position: absolute;
            top: 40px;
            right: 180px;
        }


    </style>
</head>
<body>
<x-app-layout>
    <div class="main">
        <h3>Task</h3>
        <div class="form">
            <form action="{{url('/update_task',$task->id)}}" method="post" class="form">
                <div class="first-side">
                    @csrf
                    <label></label>
                    <label>Name</label>
                    <br>
                    <input type="text" name="name" value="{{$task->name}}">
                    <br>
                    <label>Description</label>
                    <br>
                    <input type="text" name="description" value="{{$task->description}}">
                    <br>
                    <label>Due Date</label>
                    <br>
                    <input type="date" name="due_date" value="{{$task->due_date}}">
                    <br>
                    <br>
                    <div class="sub-tag-head">
                        <h4>Sub Tags</h4>
                        <button type="button" id="clearSelection">Clear</button>
                    </div>
                        @foreach($sub_task as $element)
                            <div class="radio">
                            <input type="checkbox" name="subtasks[]" value="{{$element->id}}" {{ $element->is_completed ? 'checked' : '' }}>
                            <p>{{$element->name}}</p>
                            </div>
                        @endforeach


                <button type="button" id="addNewSubtag" class="add-sub-tag">Add Subtag</button>
                <div id="newSubtagContainer"></div>


                <input class="update-btn" type="submit" value="Update">
                </div>
                <div class="second-side">
                    <h4 style="margin-top: -50px">Status</h4>
                    <div class="box">
                        <div class="canvas">
                            <div class="circle"></div>
                            <div class="line"></div>
                            <div class="circle"></div>
                        </div>
                        <div class="content">
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add new subtag input dynamically
            document.getElementById('addNewSubtag').addEventListener('click', function () {
                const container = document.getElementById('newSubtagContainer');
                const subtagDiv = document.createElement('div');
                subtagDiv.className = 'subtag';

                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'newSubtags[]';

                subtagDiv.appendChild(input);
                container.appendChild(subtagDiv);
            });
            document.getElementById('clearSelection').addEventListener('click', function () {
                const checkboxes = document.querySelectorAll('.radio input[type=checkbox]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
            });
        });
    </script>
</x-app-layout>
</body>
</html>
