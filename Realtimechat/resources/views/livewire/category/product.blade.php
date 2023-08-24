<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div>
                <label class="block font-semibold mt-4 mb-2">Image</label>
                <input class="p-2 border rounded" type="file" wire:model="image">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block font-semibold mt-4 mb-2">Title</label>
                <input class="w-full p-2 border rounded" type="text" wire:model="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block font-semibold mb-2">Category</label>
                {{-- <select class="js-example-basic-multiple" wire:model="subcategory" multiple="multiple"> --}}
                <select class="w-full p-2 border rounded" wire:model="subcategory">
                    <option value="">Select Category</option>
                    @foreach ($subCategory as $subcat)
                        <option value="{{ $subcat->id }}">{{ $subcat->title }}</option>
                    @endforeach
                </select>
                @error('subcategory')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div>
                <label class="block font-semibold mt-4 mb-2">Description</label>
                <textarea class="w-full p-2 border rounded" wire:model="description"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block font-semibold mt-4 mb-2">Product Features </label>

                @foreach ($features as $index => $features)
                    <div wire:key="features-inputs-{{ $index }}">
                        <input type="text" wire:model="features.{{ $index }}">

                        @error('features.' . $index)
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        @if ($index === 0)
                            <button type="button" wire:click="addFeatures" class="btn btn-primary">Add More</button>
                        @else
                            <button type="button" wire:click="removeFeatures({{ $index }})"
                                class="btn btn-danger">Remove</button>
                        @endif
                    </div>
                @endforeach

                <span class="text-danger">
                    @error('features')
                        {{ $message }}
                    @enderror
                </span>
            </div>


            <div>
                <label class="block font-semibold mt-4 mb-2">Product Specification</label>

                @foreach ($specification as $index => $spec)
                    <div wire:key="specification-inputs-{{ $index }}">
                        <input type="text" wire:model="specificationTitle.{{ $index }}">
                        <textarea type="text" wire:model="specificationDescrp.{{ $index }}"></textarea>
                        @error('specificationTitle.' . $index)
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('specificationDescrp.' . $index)
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @if ($index === 0)
                            <button type="button" wire:click="addSpecification" class="btn btn-primary">Add
                                More</button>
                        @else
                            <button type="button" wire:click="removeSpecification({{ $index }})"
                                class="btn btn-danger">Remove</button>
                        @endif
                    </div>
                @endforeach

                <span class="text-danger">
                    @error('specificationTitle')
                        {{ $message }}
                    @enderror
                    @error('specificationDescrp')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <button class="mt-4 px-4 py-2 bg-blue-500 rounded hover:bg-blue-600" type="submit"
                wire:click="store">Save</button>
        </div>

    </div>


    <div class="listing-category">
        <table class="table">
            <thead>
                <tr>
                    <th> S.No. </th>
                    <th> Image </th>
                    <th> Title </th>
                    <th> Description </th>
                    <th> Category </th>
                    <th> Product Features </th>
                    <th> Product Specification </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                @if (count($products) > 0)
                    @foreach ($products as $product)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td><img src="{{ asset($product->getFirstMediaUrl('image')) }}" style="max-width: 100px;">
                            </td>
                            </td>
                            <td>{{ $product->title }} </td>
                            <td>{{ $product->description }} </td>
                            <td>
                                @if ($product->subCategories)
                                    @foreach ($product->subCategories as $category)
                                        {{ $category->title }}
                                    @endforeach
                                @endif

                            </td>
                            <td>
                                @if ($product->productFeature)
                                    @foreach ($product->productFeature as $feature)
                                        {{ $feature->title }}
                                        {{-- {{ json_decode($feature->title) }} --}}
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($product->ProductSpecification)
                                    @foreach ($product->ProductSpecification as $specification)
                                        {{ $specification->title }}
                                        {{-- {{ $specification->description }} --}}
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="javascript::void(0)" id="editModal" class="unlockss"
                                    wire:click="edit({{ $product->id }})"><i
                                        class="fa-solid fa-pen-to-square"></i></a>

                                <a href="javascript::void(0)" class="red-bordered-full-btn remove-member"
                                    wire:click="delete({{ $product->id }})"><i class="fa-solid fa-trash"></i></a>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endpush
