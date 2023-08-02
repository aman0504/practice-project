<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <h1 x-data="{ message: 'I ❤️ Alpine' }" x-text="message"></h1>


    <div x-data="{ open: false }">
        <button @click="open = !open">Click to List Categories</button>
        <ul x-show="open">
            <li>PHP</li>
            <li>Laravel</li>
            <li>Vue</li>
            <li>React</li>
        </ul>
    </div>

    <br><br>

    <form @submit.prevent="saveData" x-show="addMode">
        <label> Name </label>
        <input type="text" placeholder="name" x-model="form.name" /> <br> <br>
        <label> Email </label>
        <input type="text" placeholder="email" x-model="form.email" /> <br> <br>

        <button>Submit</button>
    </form>



    <br><br><br>
    <div class="card">
        <div class="card-header text-light bg-dark">
            <span x-show="addMode">Create Student</span> <br>
            <span x-show="!addMode">Edit Student</span>
        </div>

        <div>
            <form @submit.prevent="saveData" x-show="addMode">
                <label> Name </label>
                <input type="text" placeholder="name" x-model="form.name" /> <br> <br>
                <label> Email </label>
                <input type="text" placeholder="email" x-model="form.email" /> <br> <br>

                <button>Submit</button>
            </form>
        </div>

        <br>
       



       





</body>


</html>
