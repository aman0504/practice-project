<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css"></script>
</head>

<body>

    <div class="container">
        <h3>Integrate Spatie Medialibrary in Laravel </h3>
        <form action="{{ route('spatieimage.store') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="form-group">
                <label for="email">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>

            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" id="cropperImage" class="form-control">
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>

    <div>
        <div class="container">
            <div class="d-flex p-2 bd-highlight mb-3">

            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="30%">Avatar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td><img src="{{ url('storage/' . $item->getFirstMedia('image')->id . '/' . $item->getFirstMedia('image')->file_name) }}"
                                    width="120px"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css">
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const image = document.getElementById('cropperImage');
            const cropper = new Cropper(image, {
                aspectRatio: 1, // Adjust the aspect ratio as needed
                viewMode: 1 // Set the view mode (e.g., 0 = Free, 1 = Crop Box, 2 = Preview)
                // Add any additional configuration options you require
            });
        });
    </script>



</body>

</html>
