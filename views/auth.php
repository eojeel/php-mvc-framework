<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?= $this->title ?></title>
    <meta name="author" content="name" />
    <meta name="description" content="description here" />
    <meta name="keywords" content="keywords,here" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!--Replace with your tailwind.css once created-->
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!--Container-->
    <div class="container w-full md:max-w-3xl mx-auto pt-20">

    {{content}}

    </div>


</body>
</html>
