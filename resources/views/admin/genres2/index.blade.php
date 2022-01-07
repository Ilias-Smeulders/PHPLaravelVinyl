@extends('layouts.template')

@section('title', 'Genres (advanced)')

@section('main')
    <h1>Genres</h1>
    <p>
        <a href="#!" class="btn btn-outline-success" id="btn-create">
            <i class="fas fa-plus-circle mr-1"></i>Create new genre
        </a>
    </p>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Genre</th>
                <th>Records for this genre</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
@section('script_after')
    <script>
        loadTable();    // Execute the function  loadTable() as soon as the page loads
        // Popup a dialog
        $('tbody').on('click', '.btn-delete', function () {
            // Get data attributes from td tag
            const id = $(this).closest('td').data('id');
            const name = $(this).closest('td').data('name');
            const records = $(this).closest('td').data('records');
            // Set some values for Noty
            let text = `<p>Delete the genre <b>${name}</b>?</p>`;
            let type = 'warning';
            let btnText = 'Delete genre';
            let btnClass = 'btn-success';
            // If records not 0, overwrite values for Noty
            if (records > 0) {
                text += `<p>ATTENTION: you are going to delete ${records} records at the same time!</p>`;
                btnText = `Delete genre + ${records} records`;
                btnClass = 'btn-danger';
                type = 'error';
            }
            // Show Confirm Dialog
            let modal = new Noty({
                type: type,
                text: text,
                buttons: [
                    Noty.button(btnText, `btn ${btnClass}`, function () {
                        // Delete genre and close modal
                        deleteGenre(id);
                        modal.close();
                    }),
                    Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                        modal.close();
                    })
                ]
            }).show();
        });

        // Delete a genre
        function deleteGenre(id) {
            function deleteGenre(id) {
                // Delete the genre from the database
                let pars = {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'delete'
                };
                $.post(`/admin/genres2/${id}`, pars, 'json')
                    .done(function (data) {
                        console.log('data', data);
                        // Show toast
                        VinylShop.toast({
                            type: data.type,    // optional because the default type is 'success'
                            text: data.text,
                        });
                        // Rebuild the table
                        loadTable();
                    })
                    .fail(function (e) {
                        console.log('error', e);
                    });
            }
        }
        // Load genres with AJAX
        function loadTable() {
            $.getJSON('/admin/genres2/qryGenres')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                        let tr = `<tr>
                               <td>${value.id}</td>
                               <td>${value.name}</td>
                               <td>${value.records_count}</td>
                               <td data-id="${value.id}"
                                   data-records="${value.records_count}"
                                   data-name="${value.name}">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#!" class="btn btn-outline-success btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#!" class="btn btn-outline-danger btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                               </td>
                           </tr>`;
                        // Append row to tbody
                        $('tbody').append(tr);
                    });
                })
                .fail(function (e) {
                    console.log('error', e);
                })
        }
    </script>
@endsection
