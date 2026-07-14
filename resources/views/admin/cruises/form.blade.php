@csrf

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Cruise Name</label>
        <input type="text"
               name="cruise_name"
               class="form-control @error('cruise_name') is-invalid @enderror"
               value="{{ old('cruise_name', $cruise->cruise_name ?? '') }}">

        @error('cruise_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Destination</label>
        <input type="text"
               name="destination"
               class="form-control @error('destination') is-invalid @enderror"
               value="{{ old('destination', $cruise->destination ?? '') }}">

        @error('destination')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Departure Port</label>
        <input type="text"
               name="departure_port"
               class="form-control @error('departure_port') is-invalid @enderror"
               value="{{ old('departure_port', $cruise->departure_port ?? '') }}">

        @error('departure_port')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Capacity</label>
        <input type="number"
               name="capacity"
               class="form-control @error('capacity') is-invalid @enderror"
               value="{{ old('capacity', $cruise->capacity ?? '') }}">

        @error('capacity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
    <label class="form-label">Available Slots</label>

    <input
        type="number"
        class="form-control"
        value="{{ old('available_slots', $cruise->available_slots ?? '') }}"
        readonly>

    <small class="text-muted">
        Available slots are automatically set to the cruise capacity when a new cruise is created.
    </small>
</div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Ticket Price</label>
        <input type="number"
               step="0.01"
               name="ticket_price"
               class="form-control @error('ticket_price') is-invalid @enderror"
               value="{{ old('ticket_price', $cruise->ticket_price ?? '') }}">

        @error('ticket_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Departure Date</label>
        <input type="date"
               name="departure_date"
               class="form-control @error('departure_date') is-invalid @enderror"
               value="{{ old('departure_date', isset($cruise) ? optional($cruise->departure_date)->format('Y-m-d') : '') }}">

        @error('departure_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Departure Time</label>
        <input type="time"
               name="departure_time"
               class="form-control @error('departure_time') is-invalid @enderror"
               value="{{ old('departure_time', $cruise->departure_time ?? '') }}">

        @error('departure_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Arrival Date</label>
        <input type="date"
               name="arrival_date"
               class="form-control @error('arrival_date') is-invalid @enderror"
               value="{{ old('arrival_date', isset($cruise) ? optional($cruise->arrival_date)->format('Y-m-d') : '') }}">

        @error('arrival_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>

        <select name="status"
                class="form-select">

            <option value="Available">Available</option>

            <option value="Limited Slots">Limited Slots</option>

            <option value="Fully Booked">Fully Booked</option>

            <option value="Cancelled">Cancelled</option>

        </select>

    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Description</label>

        <textarea name="description"
                  rows="5"
                  class="form-control">{{ old('description', $cruise->description ?? '') }}</textarea>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Cruise Image</label>

        <input type="file"
               name="image"
               class="form-control">

        @isset($cruise)
            @if($cruise->image)
                <img src="{{ asset('storage/'.$cruise->image) }}"
                     class="img-thumbnail mt-2"
                     width="180">
            @endif
        @endisset
    </div>

</div>

<button class="btn btn-primary">
    Save Cruise
</button>

<a href="{{ route('cruises.index') }}"
   class="btn btn-secondary">
    Cancel
</a>