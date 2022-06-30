@extends('layout')

@section('content')
    <div class="container">
        <a href="/show">View Events</a>
        <form id="event" method="post" action="{{ route('addEvent') }}">
            @csrf
            <h3>Event App CRUD</h3>
            <h4>Add New Event</h4>

            <div class="form-group">
                <label for="event_name">Event Title</label>
                <input type="text" name="event_name" class="form-control" id="event_name">
            </div>
            <div class="form-group">
                <label for="event_start_date">Event Start Date</label>
                <input type="date" name="event_start_date" class="form-control" id="event_start_date">
            </div>
            <div class="form-group">
                <label for="event_end_date">Event End Date</label>
                <input type="date" name="event_end_date" class="form-control" id="event_end_date">
            </div>
            <div class="form-group">
                <label for="event_description">Event Description</label>
                <textarea class="form-control" name="event_description" id="event_description" rows="5"></textarea>
            </div>
            <div class="row">
                <div class="col text-center">
                    <button class="btn btn-primary w-100 mt-3" type="submit">Add Event</button>
                </div>
            </div>
            <div class="col-md-12">
                <div id="success-div">
                    <p id="success" style="color: green"></p>
                </div>
            </div>

            <div class="col-md-12">
                <div id="fail-div">
                    <p id="fail" style="color: red"></p>
                </div>
            </div>
        </form>
    </div>

    <script>
        $('#event').on('submit', function(event) {
            event.preventDefault();
            let formData = $('#event').serialize();
            submitForm(formData);
        })

        function submitForm(formData) {
            $.ajax({
                url: "{{ route('addEvent') }}",
                method: 'POST',
                data: formData,
                dataType: 'JSON',
                success: function(res) {
                    if (res.status == "success") {
                        $("#success-div").addClass("alert alert-success");
                        $("#success").html(res.message);
                        $("#fail-div").removeClass("alert alert-danger");
                        $("#fail").html('');
                        window.location = res.link;
                    } else {
                        $("#fail-div").addClass("alert alert-danger")
                        $("#fail").html(res.message);
                        $("#success-div").removeClass("alert alert-success");
                        $("#success").html('');
                    }
                }
            })
        }
    </script>
@endsection
