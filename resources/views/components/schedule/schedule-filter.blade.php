<select class="selectElement" data-filter-url="{{ $filterUrl }}">
    <option value="" disabled selected>Выберите курс...</option>
    @foreach($courses as $course)
        <option value="{{ $course->id }}">{{ $course->title }}</option>
    @endforeach
</select>

<div id="schedule-results" class="schedule-results"></div>
