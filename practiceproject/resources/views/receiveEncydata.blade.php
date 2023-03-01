<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h2>Receive Encypt data and Decrypt it and show</h2>

    <h4>Send data from PracticeController in Encrypted from and in PracticeReceiverCOntroller Decrypt it </h4>

    <table border="1px">
        <tr>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>CODE</th>
        </tr>
{{-- {{dd($details['name'])}}  --}}

        <tr>
            <td>{{ @$details['name'] }}</td>
            <td>{{ @$details['email'] }}</td>
            <td>{{ @$details['code'] }}</td>
        </tr>


    </table>
</body>

</html>
