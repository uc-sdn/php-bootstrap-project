<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a98ee9cbe5.js" crossorigin="anonymous"></script>
    <script src="jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <style>
        html
        {
            scroll-behavior: smooth;
        }
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            position: relative;
            /* background-color: red; */
            min-height: 100vh;
        }
        .row{
            /* border: 1px solid black; */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 5px 0;
        }
        .col-5{
            height: 50px;
        }
        .col-5 img{
            width: 150px;
            mix-blend-mode: multiply;
        }
        .col-7
        {
            font-size:25px;
        }
        .slide{
            left: 0;
        }
        .question{
            font-size: 18px;
        }

        .ans{
            line-height: 14px;
            padding: 3px 3px;
            margin: 1px;
            float: left;
            text-align: center;
            border-radius: 50%;
            color: #aea8a8;
            background: #fff;
            border: 1px solid #aea8a8;
            font-size: 13px;
            font-weight: 700;
            width: 22px;
            height: 22px;
        }
        .ans_option
        {
            font-size: 18px;
        }
        .correct{
            color: green;
        border: 1px solid green;
        }
        .incorrect{
            color: red;
        border: 1px solid red;
        }

        .fixed-top{
            box-shadow: 5px 0 10px rgba(0, 0, 0, 0.1);
            left: -100%;
            position: absolute; 
            transition: .5s ease;
            overflow: scroll;
            /* text-align: center; */
        }
        .bottomNav
        {
            width: 700px;
            /* background-color: pink; */
            position: absolute;
            bottom: 50px;
            right: 50px;
        }
        .slide{
            left: 0;
        }
        .question{
            font-size: 18px;
        }
        
        seq:before {
            content: attr(no);
        }
        .side_list
        {
            border-bottom: 1px solid #e6e3e3;
        }
        .side_list:last-child
        {
            border: none;
        }
        .active
        {
            color: blue;
        }
    </style>
</head>
<body>
    <div class="row bg-light px-2 m-1 shadow-xl border-bottom">
        <div class="col-5 justify-content-left d-flex align-items-center">
            <a href="index.php"><img src="logo.png"></div></a>
        <div class="col-7 justify-content-left d-flex align-items-center">
            uCertify test prep
        </div>
    </div>
<script src="script.js"></script>

</body>
</html>