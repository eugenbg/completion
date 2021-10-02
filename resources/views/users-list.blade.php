<ul>
    @foreach ($users as $user)
        <li>name: {{ $user->name }}, email: {{ $user->email }}, registered: {{$user->created_at}} </li>
    @endforeach
</ul>