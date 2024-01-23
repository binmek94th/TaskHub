<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Category</title>
    <style>
        form{
            color: white;
            margin-left: 10%;
            margin-top: 20px;
        }
        .add h3{
            padding-top: 80px;
        }
        h3{
            color: white;
            padding-left: 10%;
            font-size: 26px !important;
            font-weight: bold !important;
        }
        .side h3{
            margin-top: -20px;
            margin-bottom: 40px;
        }

        input[type="text"]{
            margin-top: 15px;
            border-radius: 15px;
            width: 280px;
            color: black;
        }
        input[type="submit"]{
            margin-top: 50px;
            width: 80px;
            height: 30px;
            background-color: #6774f3;
            border-radius: 15px;
            cursor: pointer;
        }
        input[type="submit"]:hover{
            background-color: #7f8ae8;
        }
        .main{
            display: flex;
        }
        .side{
            margin-top: 50px;
            width: 40%;
            color: white;
            padding: 50px;
        }
        .add{
            margin-left: -5%;
            width: 60%;
        }
        .box{
            background-color: #1c233a;
            border-radius: 10px;
            width: 65%;
            padding: 5px;
            height: 35px;
            padding-left: 10%;
            margin-bottom: 15px;
            margin-left: 10%;
            display: flex;
        }
        .side p{
            padding-right: 110px;
            width: 140px;
            white-space: pre;
        }
        .side a{
            padding-right: 20px;
        }
        .modify a:hover{
            color: orange;
        }
        .modify{
            display: flex;
        }
        .delete a:hover{
            color: red;
        }
    </style>
</head>
<body>
<x-app-layout>
    <div class="main">
        <div class="side">
            <h3>Categories</h3>
            @foreach($categories as $element)
                <div class="box">
                    <p>{{$element->name}}</p>
                    <div class="modify">
                        <a href="{{url('edit', $element->id)}}">Edit</a>
                        <div class="delete">
                            <a href="{{url('delete')}}">Delete</a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
        <div class="add">
            <h3>Edit Category</h3>
            <form action="{{ url('/update', $category->id) }}" method="post">
            @csrf
                <label for="name">Category Name</label>
                <br>
                <input type="text" name="name" value="{{$category->name}}">
                <br>
                <input type="submit" value="Update">
            </form>
        </div>
    </div>
</x-app-layout>
</body>
</html>
