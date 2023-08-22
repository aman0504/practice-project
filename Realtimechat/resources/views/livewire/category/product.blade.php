<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <label class="block font-semibold mt-4 mb-2">Image</label>
            <input class="p-2 border rounded" type="file" name="image">

            <label class="block font-semibold mt-4 mb-2">Title</label>
            <input class="w-full p-2 border rounded" type="text" name="title">

            <label class="block font-semibold mb-2">Category</label>
            <select class="w-full p-2 border rounded" name="subcategory">
                <option value="">Select Category</option>
                @foreach ($subCategory as $subcat)
                    <option value="{{ $subcat->id }}">{{ $subcat->title }}</option>
                @endforeach
            </select>

            <label class="block font-semibold mt-4 mb-2">Description</label>
            <textarea class="w-full p-2 border rounded" name="description"></textarea>
            <div>
                <label class="block font-semibold mt-4 mb-2">Product Features </label>
                <input type="text" name="features">
                <div class="col-md-2">
                    <button class="btn text-white btn-info btn-sm"
                        wire:click.prevent="add({{ $i }})">Add</button>
                </div>
                @foreach ($inputs as $key => $value)
                    <input type="text" name="features">
                    <div class="col-md-2">
                        <button class="btn btn-danger btn-sm"
                            wire:click.prevent="remove({{ $key }})">Remove</button>
                    </div>
                @endforeach
            </div>
            <label class="block font-semibold mt-4 mb-2">Product Specification </label>

            <button class="mt-4 px-4 py-2 bg-blue-500 rounded hover:bg-blue-600" type="submit" wire:click="store">Save</button>
        </div>

    </div>
</div>
