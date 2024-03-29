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
            margin-top: 50px;
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
            width: 60%;
            margin-right: 100px;
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
            margin-top: 20px;
            margin-bottom: 50px;
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
            margin-bottom: 40px;
            width: 70%;
            height: 600px;
            border-radius: 15px;
            padding-top: 30px;
        }
        .circle{
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #6774f3;
        }
        .line{
            position: relative;
            left: 1mm;
            width: 2px;
            height: 30px;
            background-color: #6774f3;
            margin-bottom: -50px;
        }

        .checkbox, .checkbox-completed{
            display: flex;
            padding-left: 10px;
        }
        .checkbox input[type=checkbox], .checkbox-completed[type=checkbox]{
            margin-right: 10px;
        }

        .checkbox label , .checkbox-completed label{
            margin-top: -5px;
            margin-bottom: 15px;
            width: 100px;
        }
        .checkbox-completed label{
            margin-left: 10px;
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
            margin-bottom: 10px;
        }
        .update-btn{
            position: absolute;
            top: 40px;
            right: 180px;
        }
        h5{
            margin-top: 10px !important;
            font-size: 20px !important;
            margin-bottom: 10px !important;
        }
        .header{
            display: flex;
            margin-bottom: -50px;
        }
        .header input[type=checkbox]{
            margin-top: 5px;
            height: 30px;
            width: 30px;
            margin-right: 20px;
        }
        .delete{
            right: 340px;
            background-color: red !important;
            position: absolute;
            top: 92px;
            width: 90px;
            height: 40px;
            border-radius: 15px;
            padding-top: 8px;
            padding-left: 20px;
            font-size: 17px;
        }
        .delete:hover{
            background-color: #e74949 !important;
        }
        .delete-sub-task{
            margin-left: 18%;
            margin-top: -5px;
            font-size: 15px;
            color: red;
        }
        .delete-sub-task:hover{
            color: #d96d6d;
        }
        .status{
            position: relative;
            left: 30px;
            top: 5px;
            margin: 0 !important;
        }
        .content{
            padding-left: 20px;
        }


    </style>
</head>
<body>
<x-app-layout>
    <div class="main">
        <form action="{{url('/update_task',$task->id)}}" method="post">
        <div class="header">
            <input type="checkbox" value="1" name="task_completed" {{ $task->is_completed ? 'checked' : '' }}>
            <h3>Task</h3>
        </div>
        <div class="form">
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
                    <div class="subtag-container" id="newSubtagContainer">
                        @foreach($sub_task as $element)
                            <div class="checkbox">
                                @if(!$element->is_completed)
                                    <input type="checkbox" name="subtasks[]" value="{{$element->id}}" {{ $element->is_completed ? 'checked' : '' }}>
                                    <label for="subtasks[]">{{$element->name}}</label>
                                    <div class="delete-sub-task">
                                        <a onclick="return confirm('are you sure?')" href="{{url('delete_sub_task', $element->id)}}">Delete</a>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <h5>Completed</h5>
                        @foreach($sub_task as $element)
                            <div class="checkbox-completed">
                                @if($element->is_completed)
                                    <input type="checkbox" name="subtasks[]" value="{{$element->id}}" {{ $element->is_completed ? 'checked' : '' }}>
                                    <label for="subtasks[]">{{$element->name}}</label>
                                    <div class="delete-sub-task">
                                        <a onclick="return confirm('are you sure?')" href="{{url('delete_sub_task', $element->id)}}">Delete</a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>



                <button type="button" id="addNewSubtag" class="add-sub-tag">Add Subtag</button>
                <div class="delete-link">
                    <a class="delete" onclick="return confirm('are you sure?')" href="{{url('delete_task', $task->id)}}">Delete</a>
                </div>
                <input class="update-btn" type="submit" value="Update">
                </div>
                <div class="second-side">
                    <h4 style="margin-top: -50px">Status</h4>
                    <div class="box">
                        <div class="content">
                            @foreach ($statuses as $status)
                                <div class="circle"></div>
                                <div class="line"></div>
                                <p class="status">{{ $status->status }}</p>
                                <br>
                            @endforeach
                        </div>

                    </div>
                </div>
        </div>
            </form>
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add new subtag input dynamically
            document.getElementById('addNewSubtag').addEventListener('click', function () {
                const container = document.getElementById('newSubtagContainer');
                const subtagDiv = document.createElement('div');
                subtagDiv.className = 'checkbox subtag';

                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'newSubtags[]';

                subtagDiv.appendChild(input);

                // Append the new subtag input to the container
                container.appendChild(subtagDiv);

            });

            document.getElementById('clearSelection').addEventListener('click', function () {
                const checkboxes = document.querySelectorAll('.checkbox:not(.completed) input[type=checkbox]');

                checkboxes.forEach(checkbox => {
                    // Clear only the checkbox, not the entire container
                    checkbox.checked = false;
                });

            });

            adjustBoxHeight();
            // Function to adjust the box height based on content
            function adjustBoxHeight() {
                const box = document.querySelector('.box');
                const content = document.querySelector('.content');
                const minHeight = 350; // Minimum height in pixels

                // Set the box height to the maximum of content height and minimum height
                box.style.height = Math.max(content.offsetHeight, minHeight) + 'px';
            }
        });
    </script>
</x-app-layout>
</body>
</html>
