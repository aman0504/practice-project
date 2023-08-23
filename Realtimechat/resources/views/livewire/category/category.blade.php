<div>
    <div class="container">
        <div class="btn-container">
            <a href="{{ route('subcategory') }}" class="btn-subcategory">Subcategory</a>
        </div>
        <h2> @if($categoryId) Update @else Add @endif Category</h2>
        <div class="form-group">
            <label>Title</label>
            <input type="text" wire:model="title">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea wire:model="description"></textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="btn-container">
            @if($categoryId)
            <button class="btn-success" type="submit" wire:click="store({{$categoryId}})">Update</button>
            @else
            <button class="btn-success" type="submit" wire:click="store">Submit</button>
            @endif
        </div>
    </div>
    <br>

    <div class="listing-category">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No. </th>
                    <th scope="col"> Title </th>
                    <th scope="col"> Description </th>
                    <th scope="col"> Action </th>
                </tr>
            </thead>
            <tbody>
                @if (count($categories) > 0)
                    @foreach ($categories as $category)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $category->title }}</td>
                            <td>{{ $category->description }} </td>
                            <td>
                                <a href="javascript::void(0)" id="editModal" class="unlockss"
                                    wire:click="editCategory({{ $category->id }})"><i
                                        class="fa-solid fa-pen-to-square"></i></a>

                                <a href="javascript::void(0)" class="red-bordered-full-btn remove-member"
                                    wire:click="deleteCategory({{ $category->id }})"><i
                                        class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7"> No record Found </td>
                    </tr>
                @endif

            </tbody>
        </table>

    </div>

    <!-- Modal -->
    <div wire:ignore class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal">Modal title</h5>
                    <button type="button" wire:click="closeModel" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Title</label>
                    <input type="text" wire:model="title" />
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <label>Description</label>
                    <input type="text" wire:model="description" />
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="update">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('scripts') --}}
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
        {{-- <script>
            $(document).ready(function() {
                window.livewire.on('showModal', () => {
                    $('#editModal').modal('show');
                });

                window.livewire.on('closeModal', () => {
                    $('#editModal').modal('close');
                })
            });
        </script>
    @endpush --}}


    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .text-danger {
            color: red;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-success {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-subcategory {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
