<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<form method="post" action="{{ route('selectMultiple') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <label for="select2Multiple">Multiple Tags</label>
        <select class="js-example-basic-multiple" name="day[]" multiple>
            <option value="monday">Monday</option>
            <option value="tuesday">Tuesday</option>
            <option value="wednesday">Wednesday</option>
            <option value="thursday">Thursday</option>
        </select>
    </div>
    <button type="submit">Submit</button>

</form>

<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>


{{-- <input type="text" name= "search" placeholder="Search..."> <br><br> --}}
<table style="width:40%">
    <tr>
        <th>S.No.</th>
        <th>Days</th>
    </tr>
    @foreach ($values as $index => $record)
        <tr>
            {{-- <td scope="row">{{ $loop->iteration }}</td> --}}
            <td scope="row">{{ $index + 1 }}</td>
            {{-- <td>{{$record->day}}</td> --}}
            <td>
                {{ implode(', ', array_map('ucfirst', json_decode($record->day ?? '[]') ?? [])) }}
            </td>

        </tr>
    @endforeach
</table>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
