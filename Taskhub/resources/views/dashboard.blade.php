<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <style>
        .add a {
            font-size: 60px;
            color: black;
            position: fixed;
            right: 150px;
            bottom: 50px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #b9c4ce;
            text-align: center;
            line-height: 50px;
            text-decoration: none;
        }

        .add a:hover {
            background-color: #7c9cc2;
        }

        .main {
            margin-top: 40px;
            margin-left: 50px;
            display: flex;
            flex-wrap: wrap;
        }

        .box {
            background-color: #1c233a;
            border-radius: 15px;
            color: white;
            width: 250px;
            margin-left: 20px;
            padding: 15px;
            margin-bottom: 40px;
            position: relative; /* Add relative positioning */
        }

        .box h6 {
            margin-bottom: 10px;
            font-size: 20px !important;
            width: 150px;
        }

        .box .tasks ul {
            list-style-type: disc; /* Remove default list styling */
            padding-left: 20px; /* Remove default padding */
            margin: 0; /* Remove margin to prevent extra space */
        }

        .box .tasks li {
            margin: 0; /* Remove default margin for list items */
            color: white;
        }
        .element{
            height: 30px;
            border-radius: 15px;
            padding-left: 5px;
            margin-left: -20px;
        }
        .element:hover{
            background-color: #141c2d;
            cursor: pointer;
        }

        .add-task a {
            font-size: 16px;
            position: absolute; /* Set to absolute positioning */
            bottom: 10px; /* Adjust the bottom position as needed */
            right: 10px; /* Adjust the right position as needed */
            color: white;
            text-decoration: none;
            background-color: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .add-task a:hover {
            background-color: #0056b3;
        }
        .header{
            display: flex;
        }
        .modify{
            position: relative;
            right: -30px;
        }
        .modify:hover{
            cursor: pointer;
            color: orange;
        }
        .tasks ul.completed {
            display: none;
        }

        /* Add this style to show completed tasks when the "completed" class is present */
        .completed .element1 {
            display: none;
        }
        .completed-header{
            display: flex;
        }
        .completed-header p{
            margin-right: 100px;
        }

        .second{
            margin-left: 10px;
            margin-bottom: 10px;
        }
        .second ul:hover{
            background-color: #141c2d;
            border-radius: 15px;
        }
    </style>



</head>
<body>
<x-app-layout>

    <div class="main">

        @foreach($category as $element)
            <div class="box" id="box-{{$element->id}}">
                <div class="header">
                    <h6>{{$element->name}}</h6>
                    <div class="modify">
                        <a href="{{url('edit', $element->id)}}">Edit</a>
                    </div>
                </div>
                <div class="tasks">
                    <ul>
                        @foreach($tasks as $obj)
                            @if($element->id == $obj->category_id and $obj->is_completed == 0)
                                <div class="element">
                                    <a href="{{url('edit_task', $obj->id)}}">
                                        <ul>
                                            <li style="padding-top: 3px">{{$obj->name}}</li>
                                            <ul>
                                                @foreach($subTasks[$obj->id] as $sub)
                                                    <li>{{$sub->name}}</li>
                                                @endforeach
                                            </ul>
                                        </ul>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </ul>
                    <div class="completed-header">
                        <p>Completed</p>
                        <button id="image" class="drop rotated"><img height="15px" width="15px" src="{{ asset('image/arrow.png') }}"></button>
                    </div>
                    <div class="completed">
                        @foreach($tasks as $obj)
                            @if($element->id == $obj->category_id and $obj->is_completed == 1)
                                <div class="element1 second">
                                    <a href="{{url('edit_task', $obj->id)}}">
                                        <ul>
                                            <li style="padding-top: 3px; text-decoration: line-through">{{$obj->name}}</li>
                                            <ul>
                                                @foreach($subTasks[$obj->id] as $sub)
                                                    <li style="text-decoration: line-through">{{$sub->name}}</li>
                                                @endforeach
                                            </ul>
                                        </ul>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="add-task">
                    <a href="{{url('add_task', $element->id)}}">+ Add a task</a>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Run the script after the DOM has fully loaded
                    @foreach($category as $element1)
                    var box = document.getElementById('box-{{$element1->id}}');
                    var tasksList = box.querySelector('.tasks ul');
                    var size = tasksList.clientHeight;

                    if (size < 1) {
                        size = 130; // Default box size increased by 50px
                    } else {
                        size += 140;
                    }
                    box.style.height = size + 'px';

                    var elements = document.querySelectorAll('.element');
                    elements.forEach(function(element) {
                        var elementList = element.querySelector('ul');
                        var elementSize = elementList.clientHeight;
                        elementSize += 3;
                        element.style.height = elementSize + 'px';
                    });
                    @endforeach
                });
            </script>
        @endforeach
    </div>

    <!-- Move the "Add category" link outside of the .main container -->
    <div class="add">
        <a href="{{'/add_category'}}">+</a>
    </div>

</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($category as $element)
        // Add a click event listener to the drop button in each box
        var dropButton = document.querySelector('#box-{{$element->id}} .drop');
        dropButton.addEventListener('click', function() {
            var box = document.getElementById('box-{{$element->id}}');

            // Check if the initial height has been recorded
            var initialHeightRecorded = box.getAttribute('data-initial-height-recorded');
            if (!initialHeightRecorded) {
                // If not recorded, store the initial height
                box.setAttribute('data-initial-height', box.clientHeight);
                box.setAttribute('data-initial-height-recorded', 'true');
            }

            var completedTasks = document.querySelectorAll('#box-{{$element->id}} .completed .element1');

            // Toggle the visibility of completed tasks
            completedTasks.forEach(function(task) {
                task.style.display = (task.style.display === 'none' || task.style.display === '') ? 'block' : 'none';
            });

            // After toggling visibility, dynamically adjust the box height
            var tasksList = box.querySelector('.completed ul');
            var size = tasksList.clientHeight;

            // Get the recorded initial height
            var initialHeight = parseFloat(box.getAttribute('data-initial-height'));

            // Set the box height based on the initial height plus the calculated size
            box.style.height = (initialHeight + size) + 'px';
        });
        @endforeach
    });
</script>


</body>
</html>
