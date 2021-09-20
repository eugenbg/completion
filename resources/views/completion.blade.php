<form method="POST" action="/">
    @csrf

    <textarea rows="5" cols="50" name="text"></textarea>
    <button type="submit">Complete</button>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <pre>{{$text}}</pre>
</form>