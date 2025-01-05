<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API QLCV</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <h1
        class="flex justify-center items-center text-4xl font-bold h-screen w-screen bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-transparent bg-clip-text">
        <div class="flex flex-col gap-2">
            <h2>Welcome Thơ Đồ API</h2>
            <a href="{{ url('/api/redirect') }}" class=" rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white text-center shadow-sm
                hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                focus-visible:outline-indigo-600">
                Login with GG
            </a>
        </div>
    </h1>
</body>

</html>