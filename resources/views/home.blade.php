@extends('layouts.app')


@section('content')
<div class="container col-6 text-center">
    <div class="heading">
        <h1>Star Wars API</h1>
    </div>
    <div class="form-group">
        <button class="btn btn-primary people">Pull People/Characters</button>
        <button class="btn btn-secondary films">Pull Films</button>
        <button class="btn btn-success save">Save Data</button>
    </div>
</div>

<div class="container col-10">

    @include('tables.people')

    @include('tables.films')

</div>

@endsection

@section('scripts')
<script>
let people = [];
let films = [];
$(document).ready(function () {
    $('#sw-people, #sw-films').hide()
})

function personDetails(d) {
    var films = d.films.join('<br>')
    var vehicles = d.vehicles.join('<br>')
    var starships = d.starships.join('<br>')

    return '<table cellpadding="5" class="personDetails d-none" cellspacing="0" border="0" style="padding-left:50px; width: 100%">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td class="detail">'+d.name+'</td>'+
            '<td>Height:</td>'+
            '<td class="detail">'+d.height+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Mass:</td>'+
            '<td class="detail">'+d.mass+'</td>'+
            '<td>Hair Color:</td>'+
            '<td class="detail">'+d.hair_color+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Skin Color:</td>'+
            '<td class="detail">'+d.skin_color+'</td>'+
            '<td>Eye Color:</td>'+
            '<td class="detail">'+d.eye_color+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Birth Year:</td>'+
            '<td class="detail">'+d.birth_year+'</td>'+
            '<td>Gender:</td>'+
            '<td class="detail">'+d.gender+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Homeworld:</td>'+
            '<td class="detail">'+d.homeworld+'</td>'+
            '<td>Films:</td>'+
            '<td class="detail">'+films+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Species:</td>'+
            '<td class="detail">'+d.species+'</td>'+
            '<td>Vehicles:</td>'+
            '<td class="detail">'+vehicles+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Starships:</td>'+
            '<td class="detail">'+starships+'</td>'+
        '</tr>'+
    '</table>';
}

$('.people').click(function () {
    $('#sw-films').hide().DataTable().destroy()
    $('#sw-people').DataTable().destroy()
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
            { data: 'gender' },
            { data: 'birth_year' },
        ],
        initComplete: function () {
            $('td.details-control').each(function(){
                var tr = $(this).closest('tr')
                var row = table.row( tr )
                people.push(row.data())

                if (!row.child.isShown()) {
                    row.child( personDetails(row.data()) ).show()
                }
            })

            $('#sw-people tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr')
                var row = table.row( tr )

                if (!$(this).parent('tr').next('tr').find('.personDetails').hasClass('d-none')) {
                    $(this).parent('tr').next('tr').find('.personDetails').addClass('d-none')
                    tr.removeClass('shown')
                }
                else {
                    $(this).parent('tr').next('tr').find('.personDetails').removeClass('d-none')
                    tr.addClass('shown')
                }
            })

        }
    })

    

})

function filmDetails(d1) {
    var characters1 = d1.characters.join('<br>')
    var planets1 = d1.planets.join('<br>')
    var vehicles1 = d1.vehicles.join('<br>')
    var species1 = d1.species.join('<br>')
    var starships1 = d1.starships.join('<br>')

    return '<table class="filmDetails d-none" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width: 100%;">'+
        '<tr>'+
            '<td>Title:</td>'+
            '<td class="detail">'+d1.title+'</td>'+
            '<td>Characters:</td>'+
            '<td class="detail">'+characters1+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Director:</td>'+
            '<td class="detail">'+d1.director+'</td>'+
            '<td>Producer:</td>'+
            '<td class="detail">'+d1.producer+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Episode ID:</td>'+
            '<td class="detail">'+d1.episode_id+'</td>'+
            '<td>Release Date:</td>'+
            '<td class="detail">'+d1.release_date+'</td>'+
        '</tr>'+
        '<tr colspan="2">'+
            '<td>Opening Crawl:</td>'+
            '<td class="detail">'+d1.opening_crawl+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Planets:</td>'+
            '<td class="detail">'+planets1+'</td>'+
            '<td>Starships:</td>'+
            '<td class="detail">'+starships1+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Species:</td>'+
            '<td class="detail">'+species1+'</td>'+
            '<td>Vehicles:</td>'+
            '<td class="detail">'+vehicles1+'</td>'+
        '</tr>'+
    '</table>';
}

$('.films').click(function () {
    $('#sw-people').hide().DataTable().destroy()
    $('#sw-films').DataTable().destroy()
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
            { data: 'episode_id' },
            { data: 'director' },
            { data: 'producer' },
        ],
        initComplete: function () {
            $('td.details-control').each(function(){
                var tr1 = $(this).closest('tr')
                var row1 = table1.row(tr1)
                films.push(row1.data())

                if (!row1.child.isShown()) {
                    row1.child(filmDetails(row1.data())).show()
                }
            })

            $('#sw-films tbody').on('click', 'td.details-control', function () {
                var tr1 = $(this).closest('tr')
                var row1 = table1.row( tr1 )

                if (!$(this).parent('tr').next('tr').find('.filmDetails').hasClass('d-none')) {
                    $(this).parent('tr').next('tr').find('.filmDetails').addClass('d-none')
                    tr1.removeClass('shown')
                }
                else {
                    $(this).parent('tr').next('tr').find('.filmDetails').removeClass('d-none')
                    tr1.addClass('shown')
                }
            })

        }
    })

})

$('.save').click(function () {
    var pf = '';
    var type = '';

    if($('.personDetails').length > 0) {
        pf = people
        type = 'people'
    }else {
        pf = films
        type = 'films'
    }

    $.ajax({
        url: '/save',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            data: pf,
            type: type,
        },
        success: function (data) { 
            console.log(data);
         },
        error: function (jqXHR, textStatus, errorThrown) { 
            
         }
    });
})

</script>
@endsection