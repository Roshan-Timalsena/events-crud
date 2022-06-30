@extends('layout')

@section('content')
    <a href="/">Add new Event</a>
    <br>
    <a href="/show">Events</a>
    <div class="row col-md-2 mt-2 mb-4">
        <div class="form-group">
            <select class="form-select" id="filter">
                <option value="0">All Event</option>
                <option value="finished">Finished Event</option>
                <option value="upcoming">Upcoming Events</option>
                <option value="upcoming-within-seven">Upcoming Events within 7 Days</option>
                <option value="finished-before-seven">Finished Events of 7 Days</option>
            </select>
        </div>
    </div>
    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Title</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr data-id="{{ $event->id }}">
                    <th scope="row">{{ $count++ }}</th>
                    <td>{{ $event->event_name }}</td>
                    <td>{{ $event->event_start_date }}</td>
                    <td>{{ $event->event_end_date }}</td>
                    <td>{{ $event->event_description }}</td>
                    <td><button id="delete" class="btn btn-danger delete-event" data-id="{{ $event->id }}"> Delete
                            Event</button></td>
                </tr>
            @endforeach



        </tbody>
    </table>
    <div class="col-md-12">
        <div id="fail-div">
            <p id="fail" style="color: red"></p>
        </div>
    </div>

    <script>
        $('#filter').change(function() {
            let value = $(this).val();
            window.location = '/show/' + value;
        });

        $('.delete-event').on('click', function(event) {
            let id = $(this).attr('data-id');
            if (id > 0) {
                $.ajax({
                    url: "delete/" + id,
                    dataType: "JSON",
                    method: "GET",
                    success: function(res) {
                        if (res.status == 'success') {
                            location.reload();
                        } else {
                            $("#fail-div").addClass("alert alert-danger")
                            $("#fail").html("something went wrong");
                        }

                    }

                })
            }
        })
    </script>
@endsection
