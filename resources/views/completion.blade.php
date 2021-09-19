<form method="POST" action="/">
    @csrf

    <textarea rows="5" cols="50" name="text"></textarea>
    <button type="submit">Complete</button>

    <pre>{{$text}}</pre>
</form>