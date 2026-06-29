@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">

<h2 class="text-xl font-bold mb-4">Create Event</h2>

<form action="{{ route('events.store') }}" method="POST">
@csrf

<div class="mb-4">
<label>Event Code</label>
<input type="text" name="event_code" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>Event Name</label>
<input type="text" name="event_name" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>Date</label>
<input type="date" name="date" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>End Date</label>
<input type="date" name="end_date" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>Start Time</label>
<input type="time" name="start_time" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>End Time</label>
<input type="time" name="end_time" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>Location</label>
<input type="text" name="location" class="w-full border p-2 rounded">
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Save Event
</button>

</form>

</div>

@endsection