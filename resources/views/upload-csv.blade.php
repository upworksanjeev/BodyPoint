<x-mainpage-layout>
    <form method="POST" action="{{ route('import-customers') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file"/>
        <button type="submit">Upload</button>
    </form>
</x-mainpage-layout>
