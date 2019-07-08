@extends('layouts.app')


@section('content')
<div class="container col-10">
    <div class="heading text-center">
        <h1>FILMS</h1>
    </div>
    @include('tables.films2')

    <div class="heading text-center">
        <h1>CHARACTERS</h1>
    </div>
    @include('tables.people2')


</div>

@endsection

@section('scripts')
<script>
let people = [];
let films = [];

$(document).ready(function () {
})

function personDetails(d) {
    return '<table cellpadding="5" class="personDetails" cellspacing="0" border="0" style="padding-left:50px; width: 100%">'+
        '<tr>'+
            '<td>Films:</td>'+
            '<td class="films">'+d+'</td>'+
        '</tr>'+
    '</table>';
}

var table = $('#sw-people').show().DataTable({
    ajax: {
        url: 'https://swapi.co/api/people',
        dataSrc: 'results'
    },
    columns: [
        {
            "className":      'details-control',
            "orderable":      false,
            "data":           null,
            "defaultContent": ''
        },
        { data: 'name' },
    ],
    initComplete: function () {
        $('#sw-people tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
    
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                var dataFilms = ''
                $.ajax({
                    url: '/getFilms',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        data: row.data().films,
                    },
                    success: function (data) {
                        dataFilms = data.join(',<br>');
                        console.log(dataFilms);
                        row.child( personDetails(dataFilms) ).show();
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        
                    }
                });
                tr.addClass('shown');
            }
        })

    }
})

function filmDetails(d) {
    return '<table class="filmDetails" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width: 100%;">'+
        '<tr>'+
            '<td>Characters:</td>'+
            '<td class="detail">'+d+'</td>'+
        '</tr>'+
    '</table>';
}

var table1 = $('#sw-films').show().DataTable( {
    ajax: {
        url: 'https://swapi.co/api/films',
        dataSrc: 'results'
    },
    columns: [
        {
            "className":      'details-control',
            "orderable":      false,
            "data":           null,
            "defaultContent": ''
        },
        { data: 'title' },
    ],
    initComplete: function () {
        $('#sw-films tbody').on('click', 'td.details-control', function () {
            var tr1 = $(this).closest('tr');
            var row1 = table1.row( tr1 );
    
            if ( row1.child.isShown() ) {
                row1.child.hide();
                tr1.removeClass('shown');
            }
            else {
                var dataChars = ''
                $.ajax({
                    url: '/getChars',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        data: row1.data().characters,
                    },
                    success: function (data) {
                        dataChars = data.join(',<br>');
                        console.log(dataChars);
                        row1.child( personDetails(dataChars) ).show();
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 
                        
                    }
                });
                tr1.addClass('shown');
            }
        })
    }
})

</script>
@endsection