
<h1>Client Details</h1>
<p>Name: {{ $client->name }}</p>
<p>Email: {{ $client->email }}</p>
<p>Phone: {{ $client->phone }}</p>
<p>Address: {{ $client->address }}</p>

<h2>Notes</h2>
<form action="{{ route('clients.addNote', $client->id) }}" method="POST">
    @csrf
    <textarea name="content" required></textarea>
    <button type="submit">Add Note</button>
</form>

@foreach($client->notes as $note)
    <p>{{ $note->content }} ({{ $note->created_at }})</p>
@endforeach

