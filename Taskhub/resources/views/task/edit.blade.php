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

    </style>
</head>
<body>
<x-app-layout>
    <div class="main">
        <h3>Task</h3>
        <div class="form">
            <form action="{{url('/update_task')}}" method="post">
                @csrf
                <label>Name</label>
                <br>
                <input type="text" name="name" value="<p>{{$task->name}}</p>">
                <br>
                <label>Description</label>
                <br>
                <input type="text" name="description" value="">
                <br>
                <label>Due Date</label>
                <br>
                <input type="date" name="due_date" value="">
                <br>
                <input type="submit" value="submit">
            </form>
        </div>
    </div>
</x-app-layout>
</body>
</html>
