
<ul>
@foreach ($tweets as $tweet)
    <li>{{$tweet->body}}</li>
@endforeach
</ul>
