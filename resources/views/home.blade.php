<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Reds Show</title>
    <style>
        * {
            margin: 0;
            background-color: #1f1f1f;
        }

        nav {
            /* display: flex; */
        }

        nav>a {
            text-decoration: none;
            color: whitesmoke;
        }

        .title {
            display: flex;

        }

        .title img {
            height: 60px;
        }

        .title a {
            line-height: 60px;
            text-decoration: none;
            font-size: 1.8rem;
            font-weight: 600;
            cursor: pointer;
            color: #e70000;
        }

        header {
            display: flex;
            justify-content: space-between;
            padding: 2rem 2rem;
            line-height: 60px
        }

        @media screen and (min-width:740px) {
            header {
                padding: 2rem 8rem;
            }
        }
    </style>
</head>

<body>

    <header>

        <div class="title">
            <img src="image/logo.png" alt="" class="logo">
            <a href="#">The Reds Show</a>
        </div>
        <nav>
            <a href="#">Privacy Policy</a>
        </nav>
    </header>

    {{-- <img src="image/logo.png" alt="" class="logo"> --}}

</body>

</html>
