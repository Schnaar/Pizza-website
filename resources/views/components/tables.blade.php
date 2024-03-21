@if($style == 'hoverable')
    <table class="table table-hover">
        @elseif($style == 'striped')
            <table class="table table-striped">
                @endif
                <thead>
                <tr>
                    <th scope="col">#</th>
                </tr>
                </thead>
                <tbody>
                <!-- Rows will be included here from the parent view -->
                </tbody>
            </table>
