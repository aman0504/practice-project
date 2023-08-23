<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <label class="block font-semibold mt-4 mb-2">Image</label>
            <input class="p-2 border rounded" type="file" wire:model="image">

            <label class="block font-semibold mt-4 mb-2">Title</label>
            <input class="w-full p-2 border rounded" type="text" wire:model="title">

            <label class="block font-semibold mb-2">Category</label>
            <select class="w-full p-2 border rounded" wire:model="subcategory">
                <option value="">Select Category</option>
                @foreach ($subCategory as $subcat)
                    <option value="{{ $subcat->id }}">{{ $subcat->title }}</option>
                @endforeach
            </select>

            <label class="block font-semibold mt-4 mb-2">Description</label>
            <textarea class="w-full p-2 border rounded" wire:model="description"></textarea>
            <div>
                <label class="block font-semibold mt-4 mb-2">Product Features </label>

                @foreach ($features as $index => $features)
                    <input type="text" wire:model="features.{{ $index }}">
                    @if ($index === 0)
                        <button type="button" wire:click="addFeatures" class="btn btn-primary">Add More</button>
                    @else
                        <button type="button" wire:click="removeFeatures({{ $index }})"
                            class="btn btn-danger">Remove</button>
                    @endif
                @endforeach
            </div>
            <label class="block font-semibold mt-4 mb-2">Product Specification </label>
            <div>
                @foreach ($specification as $index => $specification)
                    <input type="text" wire:model="specificationTitle.{{ $index }}">
                    <textarea type="text" wire:model="specificationDescrp.{{ $index }}"></textarea>
                    @if ($index === 0)
                        <button type="button" wire:click="addSpecification" class="btn btn-primary">Add More</button>
                    @else
                        <button type="button" wire:click="removeSpecification({{ $index }})"
                            class="btn btn-danger">Remove</button>
                    @endif
                @endforeach
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
                @foreach($products as $product)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td><img src="{{ asset($product->getFirstMediaUrl('image')) }}"
                        style="max-width: 100px;"></td></td>
                    <td>{{$product->title}} </td>
                    <td>{{$product->description}} </td>
                    <td>Category</td>
                    <td>{{$product->productFeature->id}} </td>
                    <td>{{$product->description}} </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
