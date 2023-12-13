<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shorten URL</title>
</head>
<body>

<div>
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
            @if(session('short_url'))
                <br>
                Short URL: <a href="{{ session('short_url') }}" target="_blank">{{ session('short_url') }}</a>
            @endif
        </div>
    @endif

    @if(session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>Shorten URL</h1>

    <form action="{{ route('shorten.store') }}" method="post">
        @csrf
        <label for="original_url">Enter URL to Shorten:</label>
        <input type="text" name="original_url" id="original_url" value="{{ old('original_url') }}" required>
        <button type="submit">Shorten</button>
    </form>

    <hr>

    <h2>URL Mappings (for debugging)</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Original URL</th>
                <th>Short URL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($urlMappings as $mapping)
                <tr>
                    <td>{{ $mapping->id }}</td>
                    <td>{{ $mapping->original_url }}</td>
                    <td>{{ $mapping->short_url }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>

