<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Task</title>
    <style>
        h3{
            color: white;
            font-size: 26px !important;
            font-weight: bold !important;
            padding-bottom: 20px;
        }
        .form{
            color: white;

        }
        .main{
            margin-left: 300px;
            margin-top: 100px;
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
            width: 80px;
            height: 30px;
            background-color: #6774f3;
            border-radius: 15px;
            cursor: pointer;
            margin-left: 220px;
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
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .error-message p{
            margin-bottom: -30px;
        }
    </style>
</head>
<body>
<x-app-layout>
    <div class="main">
        <h3>Add Task</h3>
        <div class="form">
        <form action="{{url('/add_task')}}" method="post" onsubmit="return validateForm()">
            @csrf
            <input name="category" id="nameinput" value="{{$category->id}}" hidden>
            <label for="name">Name</label>
            <div id="nameError" class="error-message"><p></p></div> <!-- Display error message -->
            <br>
            <input type="text" name="name">
            <br>
            <label for="description">Description</label>
            <br>
            <input type="text" name="description">
            <br>
            <label>Due Date</label>
            <br>
            <input type="date" name="due_date">
            <br>
            <button type="button" id="addNewSubtag" class="add-sub-tag">Add Subtag</button>
            <div id="newSubtagContainer"></div>

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
                });
            </script>
            <input type="submit" value="Add">
        </form>
        </div>
    </div>
</x-app-layout>
</body>
</html>
