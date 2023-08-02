<div>
    {{-- Stop trying to control. --}}

    <form wire:submit.prevent="processPDF" enctype="multipart/form-data">
    <div class="form-group">
        <label for="exampleInputName">File:</label>
        <input type="file" class="form-control" id="exampleInputName" wire:model="pdfFile">
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
