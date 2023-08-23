<div>


    <h2> Add Subcategories </h2>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
            wire:click="showModelSubcategory">
            Add Subcategories
        </button>


        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="showSubcategory" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="showSubcategory"> <b>

                                {{ !empty($subCategoryId) ? 'Update' : 'Add' }} Category </b>
                        </h5>

                        <button type="button" wire:click="closeModel" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <select wire:model="categories_id">
                            <option value=""> Select Category </option>
                            @foreach ($categories as $catg)
                                <option value={{ $catg->id }}>{{ $catg->title }}</option>
                            @endforeach

                        </select>
                        @error('categories_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div>
                            <label>Title</label>
                            <input type="text" wire:model="title" />
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label>Image </label>
                            <input type="file" wire:model="image" />

                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" wire:click="store">
                            @if ($subCategoryId)
                                Update
                            @else
                                Add
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- table start --}}

    <div class="listing-category">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No. </th>
                    <th scope="col"> Title </th>
                    <th scope="col">Parent Category</th>
                    <th scope="col"> Image </th>
                    <th scope="col"> Action </th>
                </tr>
            </thead>
            <tbody>
                @if (count($subCategories) > 0)
                    @foreach ($subCategories as $subcategory)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $subcategory->title ?? null }}</td>
                            <td>{{ !empty($subcategory->category->title) ? $subcategory->category->title : null }}</td>
                            <td> <img src="{{ asset($subcategory->getFirstMediaUrl('image')) }}"
                                    style="max-width: 100px;"></td>
                            <td>
                                <a href="javascript::void(0)" id="editModal" class="unlockss"
                                    wire:click="edit({{ $subcategory->id }})"><i
                                        class="fa-solid fa-pen-to-square"></i></a>

                                <a href="javascript::void(0)" class="red-bordered-full-btn remove-member"
                                    wire:click="deleteCategory({{ $subcategory->id }})"><i
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

</div>

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            window.livewire.on('showModelSubcategory', () => {
                $('#showSubcategory').modal('show');
            })

            window.livewire.on('hideModelSubcategory', () => {
                $('#showSubcategory').modal('close');
            })

        });
    </script>
@endpush
