<div>
    <a href="{{route('subcategory')}}"> Subcategory </a>
    <h2> Add Category </h2>
    <div class="form-group">
        <div>
            <label>Title</label>
            <input type="text" wire:model="title" />
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <br> <br>
        <label>Description </label>
        <textarea wire:model="description"></textarea>
        @error('description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <br>
        <button class="btn btn-success" type="submit" wire:click="store"> Submit </button>
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

                                <a href="javascript::void(0)"  class="red-bordered-full-btn remove-member"
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

    @push('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                window.livewire.on('showModelCategory', () => {
                    $('#editModal').modal('show');
                });

                window.livewire.on('closeModal', () => {
                    $('#editModal').modal('close');
                })
            });
        </script>
    @endpush
